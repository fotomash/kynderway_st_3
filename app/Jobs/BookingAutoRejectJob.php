<?php

namespace App\Jobs;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\PushNotificationService;
use Kreait\Firebase\Messaging\Notification;

class BookingAutoRejectJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Booking $booking)
    {
    }

    public function handle()
    {
        if ($this->booking->status === Booking::STATUS_REQUESTED) {
            $this->booking->update(['status' => Booking::STATUS_REJECTED]);
            app(PushNotificationService::class)
                ->sendToDevice(
                    $this->booking->parent->fcm_token,
                    [
                        'booking_id' => $this->booking->id,
                        'status' => $this->booking->status,
                        'type' => 'booking_status',
                    ],
                    Notification::create(
                        'Booking Update',
                        "Your booking with {$this->booking->nanny->name} is now {$this->booking->status}"
                    )
                );
        }
    }
}
