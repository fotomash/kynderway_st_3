<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class NewJobPosted implements ShouldBroadcast
{
    use SerializesModels;

    public $jobPost;

    public function __construct($jobPost)
    {
        $this->jobPost = $jobPost;
    }

    public function broadcastOn()
    {
        return new Channel('jobs.area.' . $this->jobPost->city);
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->jobPost->id,
            'title' => $this->jobPost->title,
            'location' => $this->jobPost->address,
            'rate' => $this->jobPost->hourly_rate_min . '-' . $this->jobPost->hourly_rate_max,
            'posted_at' => $this->jobPost->created_at,
        ];
    }
}
