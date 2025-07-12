<?php

namespace Tests\Unit;

use App\Services\PushNotificationService;
use Mockery;
use Tests\TestCase;

require_once __DIR__ . '/../Stubs/FirebaseStubs.php';

class PushNotificationServiceTest extends TestCase
{
    public function test_send_to_device_sends_message()
    {
        $messaging = Mockery::mock('Kreait\\Firebase\\Messaging\\MessagingStub');
        $messaging->shouldReceive('send')->once();

        $service = (new \ReflectionClass(PushNotificationService::class))
            ->newInstanceWithoutConstructor();
        $prop = new \ReflectionProperty(PushNotificationService::class, 'messaging');
        $prop->setAccessible(true);
        $prop->setValue($service, $messaging);

        $service->sendToDevice('token', ['foo' => 'bar']);
    }
}
