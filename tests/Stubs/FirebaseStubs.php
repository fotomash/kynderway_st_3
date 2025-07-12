<?php
namespace Kreait\Firebase;
class Factory {
    public function withServiceAccount($c){ return $this; }
    public function withVerifierCache($cache){ return $this; }
    public function withAuthTokenCache($cache){ return $this; }
    public function withHttpClientOptions($opts){ return $this; }
    public function createMessaging(){ return new \Kreait\Firebase\Messaging\MessagingStub(); }
}
namespace Kreait\Firebase\Messaging;
class MessagingStub {
    public $sentMessage;
    public $subscribedTopic;
    public $subscribedTokens;

    public function send($message){
        $this->sentMessage = $message;
    }

    public function subscribeToTopic($topic, $token){
        $this->subscribedTopic = $topic;
        $this->subscribedTokens = $token;
    }
}
class CloudMessage {
    public $targetType;
    public $target;
    public $notification;
    public $data = [];

    public static function withTarget($type, $token){
        $msg = new static();
        $msg->targetType = $type;
        $msg->target = $token;
        return $msg;
    }
    public function withNotification($notification){
        $this->notification = $notification;
        return $this;
    }
    public function withData(array $data){
        $this->data = $data;
        return $this;
    }
}
class Notification {
    public static function create($title,$body){ return new static(); }
}
