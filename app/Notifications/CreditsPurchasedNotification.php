<?php

namespace App\Notifications;

use App\Models\CreditPackage;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CreditsPurchasedNotification extends Notification
{
    use Queueable;

    public function __construct(public CreditPackage $package, public int $credits)
    {
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage())
            ->subject('Credits Purchased')
            ->line("You purchased {$this->credits} credits using package {$this->package->name}.");
    }
}
