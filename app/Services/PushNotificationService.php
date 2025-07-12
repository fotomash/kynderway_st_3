<?php

namespace App\Services;

use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class PushNotificationService
{
    private $messaging;

    public function __construct()
    {
        $this->messaging = app('firebase.messaging');
    }

    public function sendToDevice(string $token, array $data = [], ?Notification $notification = null): void
    {
        $message = CloudMessage::withTarget('token', $token);

        if ($notification) {
            $message = $message->withNotification($notification);
        }

        if (!empty($data)) {
            $message = $message->withData($data);
        }

        $this->messaging->send($message);
    }

    public function sendToTopic(string $topic, array $data = [], ?Notification $notification = null): void
    {
        $message = CloudMessage::withTarget('topic', $topic);

        if ($notification) {
            $message = $message->withNotification($notification);
        }

        if (!empty($data)) {
            $message = $message->withData($data);
        }

        $this->messaging->send($message);
    }

    public function subscribeToTopic(string $topic, $tokens): void
    {
        $this->messaging->subscribeToTopic($topic, $tokens);
    }
}
