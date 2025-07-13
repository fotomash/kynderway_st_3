<?php

namespace App\Services;

use App\Models\Booking;
use Illuminate\Support\Facades\DB;
use App\Services\PushNotificationService;
use Kreait\Firebase\Messaging\Notification;
use App\Events\BookingCreated;

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

            event(new BookingCreated($booking));
            return $booking->fresh();
        });
    }

    public function completeBooking(Booking $booking): Booking
    {
        $this->paymentService->releasePayment($booking);
        $booking->update(['status' => Booking::STATUS_COMPLETED]);

        $this->notificationService->sendToDevice(
            $booking->parent->fcm_token,
            [
                'booking_id' => $booking->id,
                'status' => $booking->status,
                'type' => 'booking_status',
            ],
            Notification::create(
                'Booking Update',
                "Your booking with {$booking->nanny->name} is now {$booking->status}"
            )
        );

        return $booking->fresh();
    }
}
