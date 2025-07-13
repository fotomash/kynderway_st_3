<?php

namespace App\Http\Controllers;

use App\Events\PaymentSuccessful;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Webhook;

class StripeWebhookController extends Controller
{
    public function __invoke(Request $request): Response
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature', '');
        $secret = config('services.stripe.webhook_secret');

        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $secret);
        } catch (SignatureVerificationException $e) {
            Log::warning('Stripe webhook signature verification failed: ' . $e->getMessage());

            return response('Invalid signature', 400);
        }

        $type = $event['type'] ?? '';

        match ($type) {
            'payment_intent.succeeded' => $this->handlePaymentIntentSucceeded($event['data']['object']),
            'payment_intent.payment_failed' => $this->handlePaymentIntentFailed($event['data']['object']),
            'account.updated' => $this->handleAccountUpdated($event['data']['object']),
            'refund.created' => $this->handleRefundCreated($event['data']['object']),
            default => Log::info('Unhandled webhook event type: ' . $type),
        };

        return response('Webhook handled', 200);
    }

    private function handlePaymentIntentSucceeded(array $paymentIntent): void
    {
        DB::transaction(function () use ($paymentIntent): void {
            $payment = Payment::where('stripe_payment_intent_id', $paymentIntent['id'])->first();
            if (! $payment) {
                Log::warning('Payment not found for intent ' . $paymentIntent['id']);
                return;
            }

            $payment->update(['status' => 'succeeded']);
            $payment->booking()->update([
                'payment_status' => 'paid',
                'paid_at' => now(),
            ]);

            event(new PaymentSuccessful($payment->booking));
        });
    }

    private function handlePaymentIntentFailed(array $paymentIntent): void
    {
        Payment::where('stripe_payment_intent_id', $paymentIntent['id'])->update(['status' => 'failed']);
    }

    private function handleAccountUpdated(array $account): void
    {
        $provider = User::where('stripe_connect_id', $account['id'] ?? null)->first();
        if (! $provider) {
            return;
        }

        $provider->update([
            'stripe_onboarding_complete' => ($account['charges_enabled'] ?? false) && ($account['payouts_enabled'] ?? false),
            'stripe_account_capabilities' => [
                'charges_enabled' => $account['charges_enabled'] ?? false,
                'payouts_enabled' => $account['payouts_enabled'] ?? false,
                'requirements' => $account['requirements'] ?? [],
            ],
        ]);
    }

    private function handleRefundCreated(array $refund): void
    {
        Payment::where('stripe_payment_intent_id', $refund['payment_intent'] ?? null)
            ->update(['status' => 'refunded']);
    }
}
