<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Kreait\Firebase\Messaging\Notification as FcmNotification;

class BookingRequestNotification extends Notification
{
    use Queueable;

    public function __construct(public Booking $booking)
    {
    }

    public function via($notifiable)
    {
        return ['mail', 'push'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage())
            ->subject('New Booking Request')
            ->line('You have received a new booking request.');
    }

    public function toPush($notifiable): array
    {
        return [
            'token' => $notifiable->fcm_token,
            'data' => [
                'booking_id' => $this->booking->id,
                'type' => 'booking_request',
            ],
            'notification' => FcmNotification::create(
                'New Booking Request',
                'You have received a new booking request.'
            ),
        ];
    }
}
