<?php

namespace App\Services;

use App\Models\Booking;
use Illuminate\Support\Facades\DB;

use App\Services\PushNotificationService;
use Kreait\Firebase\Messaging\Notification;

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

            $this->notificationService->sendToDevice(
                $booking->nanny->fcm_token,
                [
                    'booking_id' => $booking->id,
                    'type' => 'new_booking',
                ],
                Notification::create(
                    'New Booking Request',
                    "{$booking->parent->name} has requested a booking"
                )
            );
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
