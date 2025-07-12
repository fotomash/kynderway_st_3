<?php

namespace App\Notifications\Channels;

use App\Services\PushNotificationService;
use Illuminate\Notifications\Notification;

/**
 * Custom notification channel forwarding payloads to PushNotificationService.
 *
 * Example usage in a notification:
 * ```php
 * public function via($notifiable)
 * {
 *     return ['mail', 'push'];
 * }
 *
 * public function toPush($notifiable)
 * {
 *     return [
 *         'token' => $notifiable->fcm_token,
 *         'data' => ['foo' => 'bar'],
 *         'notification' => FcmNotification::create('Title', 'Body'),
 *     ];
 * }
 * ```
 */
class PushNotificationChannel
{
    public function __construct(protected PushNotificationService $service)
    {
    }

    public function send($notifiable, Notification $notification): void
    {
        if (!method_exists($notification, 'toPush')) {
            return;
        }

        $payload = $notification->toPush($notifiable);

        $token = $payload['token'] ?? ($notifiable->fcm_token ?? null);
        $data = $payload['data'] ?? [];
        $notif = $payload['notification'] ?? null;

        if ($token) {
            $this->service->sendToDevice($token, $data, $notif);
        }
    }
}
