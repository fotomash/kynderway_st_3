<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Kreait\Firebase\Messaging\Notification as FcmNotification;

class ProfileUnlockedNotification extends Notification
{
    use Queueable;

    public function __construct(public User $parent)
    {
    }

    public function via($notifiable)
    {
        return ['mail', 'push'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage())
            ->subject('Profile Unlocked')
            ->line("{$this->parent->name} has unlocked your profile.");
    }

    public function toPush($notifiable): array
    {
        return [
            'token' => $notifiable->fcm_token,
            'data' => [
                'type' => 'profile_unlocked',
            ],
            'notification' => FcmNotification::create(
                'Profile Unlocked',
                "{$this->parent->name} has unlocked your profile."
            ),
        ];
    }
}
