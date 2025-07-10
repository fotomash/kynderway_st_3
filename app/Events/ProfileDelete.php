<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use App\Models\Profile_Posts;

class ProfileDelete
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public $profile_post;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Profile_Posts $profile_post)
    {
        $this->profile_post = $profile_post;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
