<?php

namespace App\Jobs;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\PushNotificationService;

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
                ->notifyParentOfStatusChange($this->booking->parent, $this->booking);
        }
    }
}
