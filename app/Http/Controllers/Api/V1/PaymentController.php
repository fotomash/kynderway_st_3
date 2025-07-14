<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\PaymentService;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function __construct(private PaymentService $paymentService)
    {
    }

    /**
     * Create a payment intent for a booking
     */
    public function createIntent(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'save_payment_method' => 'boolean',
        ]);

        try {
            $booking = Booking::findOrFail($request->booking_id);

            if ($booking->parent_id !== $request->user()->id) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }

            $intent = $this->paymentService->createPaymentIntent(
                $booking,
                $request->boolean('save_payment_method')
            );

            return response()->json([
                'client_secret' => $intent->client_secret,
                'payment_intent_id' => $intent->id,
                'amount' => $intent->amount,
                'currency' => $intent->currency,
            ]);
        } catch (\Exception $e) {
            Log::error('Payment intent creation failed: '.$e->getMessage());
            return response()->json(['error' => 'Payment processing failed'], 500);
        }
    }

    /**
     * Confirm payment intent and trigger booking updates
     */
    public function confirm(Request $request)
    {
        $request->validate([
            'payment_intent_id' => 'required|string',
            'booking_id' => 'required|exists:bookings,id',
        ]);

        try {
            $booking = Booking::findOrFail($request->booking_id);

            $payment = $this->paymentService->confirmPayment($request->payment_intent_id, $booking);

            return response()->json([
                'status' => $payment->status,
            ]);
        } catch (\Exception $e) {
            Log::error('Payment confirmation failed: '.$e->getMessage());
            return response()->json(['error' => 'Payment confirmation failed'], 500);
        }
    }

    /**
     * Process a refund for a booking
     */
    public function refund(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'amount' => 'nullable|numeric|min:0',
            'reason' => 'required|in:duplicate,fraudulent,requested_by_customer,other',
            'notes' => 'nullable|string|max:500',
        ]);

        try {
            $booking = Booking::findOrFail($request->booking_id);

            if (! $this->paymentService->canRefund($booking)) {
                return response()->json(['error' => 'Booking not eligible for refund'], 400);
            }

            $refund = $this->paymentService->createRefund(
                $booking,
                $request->input('amount'),
                $request->input('reason'),
                $request->input('notes')
            );

            return response()->json([
                'refund_id' => $refund->id,
                'amount' => $refund->amount,
                'status' => $refund->status,
            ]);
        } catch (\Exception $e) {
            Log::error('Refund failed: '.$e->getMessage());
            return response()->json(['error' => 'Refund processing failed'], 500);
        }
    }
}