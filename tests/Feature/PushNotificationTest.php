<?php

namespace Tests\Feature;

use App\Services\PushNotificationService;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Kreait\Firebase\Messaging\MessagingStub;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Firebase\Messaging\CloudMessage;
use Tests\TestCase;

require_once __DIR__ . '/../Stubs/FirebaseStubs.php';

class PushNotificationTest extends TestCase
{
    use RefreshDatabase;

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    public function test_send_to_device_builds_message_and_sends(): void
    {
        $messaging = new MessagingStub();
        $service = (new \ReflectionClass(PushNotificationService::class))
            ->newInstanceWithoutConstructor();
        $prop = new \ReflectionProperty(PushNotificationService::class, 'messaging');
        $prop->setAccessible(true);
        $prop->setValue($service, $messaging);

        $service->sendToDevice('abc', ['foo' => 'bar'], Notification::create('t', 'b'));

        $message = $messaging->sentMessage;
        $this->assertInstanceOf(CloudMessage::class, $message);
        $this->assertEquals('token', $message->targetType);
        $this->assertEquals('abc', $message->target);
        $this->assertEquals(['foo' => 'bar'], $message->data);
        $this->assertInstanceOf(Notification::class, $message->notification);
    }

    public function test_send_to_topic_builds_message_and_sends(): void
    {
        $messaging = new MessagingStub();
        $service = (new \ReflectionClass(PushNotificationService::class))
            ->newInstanceWithoutConstructor();
        $prop = new \ReflectionProperty(PushNotificationService::class, 'messaging');
        $prop->setAccessible(true);
        $prop->setValue($service, $messaging);

        $service->sendToTopic('news', ['foo' => 'bar'], Notification::create('t', 'b'));

        $message = $messaging->sentMessage;
        $this->assertInstanceOf(CloudMessage::class, $message);
        $this->assertEquals('topic', $message->targetType);
        $this->assertEquals('news', $message->target);
        $this->assertEquals(['foo' => 'bar'], $message->data);
        $this->assertInstanceOf(Notification::class, $message->notification);
    }

    public function test_device_token_registration_and_unregistration(): void
    {
        $user = User::factory()->create(['password' => bcrypt('secret')]);

        $login = $this->postJson('/api/mobile/v1/login', [
            'email' => $user->email,
            'password' => 'secret',
            'device_name' => 'testing',
        ]);
        $token = $login->json('token');

        $this->withToken($token)->postJson('/api/mobile/v1/device/register', ['token' => 'tok'])
            ->assertOk()->assertJson(['success' => true]);
        $this->assertEquals('tok', $user->fresh()->fcm_token);

        $this->withToken($token)->postJson('/api/mobile/v1/device/unregister', ['token' => 'tok'])
            ->assertOk()->assertJson(['success' => true]);
        $this->assertNull($user->fresh()->fcm_token);
    }

    public function test_subscribe_to_topic_delegates_to_firebase(): void
    {
        $messaging = new MessagingStub();
        $service = (new \ReflectionClass(PushNotificationService::class))
            ->newInstanceWithoutConstructor();
        $prop = new \ReflectionProperty(PushNotificationService::class, 'messaging');
        $prop->setAccessible(true);
        $prop->setValue($service, $messaging);

        $service->subscribeToTopic('alerts', ['a', 'b']);

        $this->assertEquals('alerts', $messaging->subscribedTopic);
        $this->assertEquals(['a', 'b'], $messaging->subscribedTokens);
    }
}
