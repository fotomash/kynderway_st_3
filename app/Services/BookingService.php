<?php

namespace App\Services;

use App\Models\Booking;
use Illuminate\Support\Facades\DB;

use App\Services\PushNotificationService;

class BookingService
{
    public function __construct(
        protected PaymentService $paymentService,
        protected PushNotificationService $notificationService
    ) {
    }

    public function createBooking(array $data): Booking
    {
        return DB::transaction(function () use ($data) {
            $booking = Booking::create($data);
            $this->paymentService->createEscrowPayment($booking);
            $this->notificationService->notifyNannyOfBooking($booking->nanny, $booking);
            return $booking->fresh();
        });
    }

    public function completeBooking(Booking $booking): Booking
    {
        $this->paymentService->releasePayment($booking);
        $booking->update(['status' => Booking::STATUS_COMPLETED]);
        $this->notificationService->notifyParentOfStatusChange($booking->parent, $booking);

        return $booking->fresh();
    }
}
