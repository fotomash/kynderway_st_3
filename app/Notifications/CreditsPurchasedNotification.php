<?php

namespace App\Notifications;

use App\Models\CreditPackage;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Kreait\Firebase\Messaging\Notification as FcmNotification;

class CreditsPurchasedNotification extends Notification
{
    use Queueable;

    public function __construct(public CreditPackage $package, public int $credits)
    {
    }

    public function via($notifiable)
    {
        return ['mail', 'push'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage())
            ->subject('Credits Purchased')
            ->line("You purchased {$this->credits} credits using package {$this->package->name}.");
    }

    public function toPush($notifiable): array
    {
        return [
            'token' => $notifiable->fcm_token,
            'data' => [
                'type' => 'credits_purchased',
                'credits' => $this->credits,
            ],
            'notification' => FcmNotification::create(
                'Credits Purchased',
                "You purchased {$this->credits} credits using package {$this->package->name}."
            ),
        ];
    }
}
