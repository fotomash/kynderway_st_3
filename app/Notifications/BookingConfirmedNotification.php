<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Kreait\Firebase\Messaging\Notification as FcmNotification;

class BookingConfirmedNotification extends Notification
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
            ->subject('Booking Confirmed')
            ->line("Your booking with {$this->booking->nanny->name} has been accepted.");
    }

    public function toPush($notifiable): array
    {
        return [
            'token' => $notifiable->fcm_token,
            'data' => [
                'booking_id' => $this->booking->id,
                'type' => 'booking_confirmed',
            ],
            'notification' => FcmNotification::create(
                'Booking Confirmed',
                "Your booking with {$this->booking->nanny->name} has been accepted."
            ),
        ];
    }
}
