<?php

namespace App\Services;

use App\Models\Booking;
use Illuminate\Support\Facades\DB;

class BookingService
{
    public function __construct(protected PaymentService $paymentService)
    {
    }

    public function createBooking(array $data): Booking
    {
        return DB::transaction(function () use ($data) {
            $booking = Booking::create($data);
            $this->paymentService->createEscrowPayment($booking);
            return $booking->fresh();
        });
    }

    public function completeBooking(Booking $booking): Booking
    {
        $this->paymentService->releasePayment($booking);
        $booking->update(['status' => Booking::STATUS_COMPLETED]);

        return $booking->fresh();
    }
}
