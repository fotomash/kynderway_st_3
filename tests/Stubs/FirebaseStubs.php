<?php
namespace Kreait\Firebase;
class Factory {
    public function withServiceAccount($c){ return $this; }
    public function createMessaging(){ return new \Kreait\Firebase\Messaging\MessagingStub(); }
}
namespace Kreait\Firebase\Messaging;
class MessagingStub {
    public function send($message){}
}
class CloudMessage {
    public static function withTarget($type, $token){ return new static(); }
    public function withNotification($notification){ return $this; }
    public function withData(array $data){ return $this; }
}
class Notification {
    public static function create($title,$body){ return new static(); }
}
