<?php

namespace App\Listeners;

use App\Events\BookingCreated;
use App\Services\PushNotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Kreait\Firebase\Messaging\Notification;

class SendBookingNotification implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(BookingCreated $event): void
    {
        $booking = $event->booking;
        $provider = $booking->nanny;

        if (!$provider || !$provider->fcm_token) {
            return;
        }

        app(PushNotificationService::class)->sendToDevice(
            $provider->fcm_token,
            [
                'booking_id' => $booking->id,
                'type'       => 'new_booking',
            ],
            Notification::create(
                'New Booking Request',
                "{$booking->parent->name} has requested a booking"
            )
        );
    }
}
