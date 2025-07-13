<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Transaction;
use App\Events\PaymentProcessed;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Transfer;
use Stripe\Refund;

class PaymentService
{
    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }
    
    /**
     * Create escrow payment for booking
     */
    public function createEscrowPayment(Booking $booking)
    {
        // Calculate fees
        $subtotal = $booking->hours * $booking->hourly_rate;
        $platformFee = $subtotal * 0.15; // 15% platform fee
        $agencyFee = 0;
        
        if ($booking->agency_id) {
            $agencyFee = $subtotal * ($booking->agency->commission_rate / 100);
        }
        
        $total = $subtotal + $platformFee;
        
        // Create payment intent
        $paymentIntent = PaymentIntent::create([
            'amount' => $total * 100, // Convert to cents
            'currency' => 'usd',
            'metadata' => [
                'booking_id' => $booking->id,
                'parent_id' => $booking->parent_id,
                'nanny_id' => $booking->nanny_id,
                'agency_id' => $booking->agency_id,
            ],
            'transfer_group' => "booking_{$booking->id}",
        ]);
        
        // Create transaction record
        $transaction = Transaction::create([
            'booking_id' => $booking->id,
            'type' => 'escrow',
            'amount' => $total,
            'subtotal' => $subtotal,
            'platform_fee' => $platformFee,
            'agency_fee' => $agencyFee,
            'stripe_payment_intent_id' => $paymentIntent->id,
            'status' => 'pending',
        ]);
        
        return $transaction;
    }
    
    /**
     * Release payment after job completion
     */
    public function releasePayment(Booking $booking)
    {
        $transaction = $booking->transaction;
        
        // Calculate payouts
        $nannyPayout = $transaction->subtotal;
        if ($booking->agency_id) {
            $nannyPayout -= $transaction->agency_fee;
        }
        
        // Transfer to nanny
        $nannyTransfer = Transfer::create([
            'amount' => $nannyPayout * 100,
            'currency' => 'usd',
            'destination' => $booking->nanny->stripe_account_id,
            'transfer_group' => "booking_{$booking->id}",
            'metadata' => [
                'booking_id' => $booking->id,
                'type' => 'nanny_payout',
            ],
        ]);
        
        // Transfer to agency if applicable
        if ($booking->agency_id && $transaction->agency_fee > 0) {
            $agencyTransfer = Transfer::create([
                'amount' => $transaction->agency_fee * 100,
                'currency' => 'usd',
                'destination' => $booking->agency->stripe_account_id,
                'transfer_group' => "booking_{$booking->id}",
                'metadata' => [
                    'booking_id' => $booking->id,
                    'type' => 'agency_commission',
                ],
            ]);
        }
        
        $transaction->update([
            'status' => 'completed',
            'released_at' => now(),
        ]);

        event(new PaymentProcessed($transaction));

        return $transaction;
    }
}
