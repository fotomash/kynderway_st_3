<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProfileUnlockedNotification extends Notification
{
    use Queueable;

    public function __construct(public User $parent)
    {
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage())
            ->subject('Profile Unlocked')
            ->line("{$this->parent->name} has unlocked your profile.");
    }
}
