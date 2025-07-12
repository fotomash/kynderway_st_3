<?php

namespace Tests\Unit;

use App\Services\PushNotificationService;
use App\Models\Booking;
use Mockery;
use Tests\TestCase;

require_once __DIR__ . '/../Stubs/FirebaseStubs.php';

class PushNotificationServiceTest extends TestCase
{
    public function test_notify_nanny_of_booking_sends_message()
    {
        $messaging = Mockery::mock('Kreait\Firebase\Messaging\MessagingStub');
        $messaging->shouldReceive('send')->once();

        $service = (new \ReflectionClass(PushNotificationService::class))
            ->newInstanceWithoutConstructor();
        $prop = new \ReflectionProperty(PushNotificationService::class, 'messaging');
        $prop->setAccessible(true);
        $prop->setValue($service, $messaging);

        $nanny = (object)['fcm_token' => 'token'];
        $parent = (object)['name' => 'Parent'];
        $booking = (object)['id' => 1, 'parent' => $parent];

        $service->notifyNannyOfBooking($nanny, $booking);
    }

    public function test_notify_parent_of_status_change_sends_message()
    {
        $messaging = Mockery::mock('Kreait\Firebase\Messaging\MessagingStub');
        $messaging->shouldReceive('send')->once();

        $service = (new \ReflectionClass(PushNotificationService::class))
            ->newInstanceWithoutConstructor();
        $prop = new \ReflectionProperty(PushNotificationService::class, 'messaging');
        $prop->setAccessible(true);
        $prop->setValue($service, $messaging);

        $parent = (object)['fcm_token' => 'token'];
        $nanny = (object)['name' => 'Nanny'];
        $booking = (object)['id' => 2, 'nanny' => $nanny, 'status' => Booking::STATUS_COMPLETED];

        $service->notifyParentOfStatusChange($parent, $booking);
    }
}
