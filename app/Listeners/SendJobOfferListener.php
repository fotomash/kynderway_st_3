<?php

namespace App\Listeners;

use App\Events\SendJobOfferEvent;
use App\Mail\SendJobOffersMail;
use App\Models\Job_Posts;
use App\Models\User;

use Mail;

class SendJobOfferListener
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(SendJobOfferEvent $event)
    {
        //Get all the active providers in the system
        $users = User::with('profileposts')->whereHas('profileposts', function ($query) {
            $query->where('status', 1)->whereNull('suspendBy');
        })->where('type', 'service_provider')->where('is_block', 0)->where('marketing', 1)->get();

        //Get all the job posts
        $job_posts = Job_Posts::whereIn('id', $event->job_ids)->get();

        $subject = 'Relevant Job Offers';

        foreach ($users as $user) {
            $job_posts_to_send = [];
            $user_profile_ids = $user->profileposts->pluck('profile_category_id')->toArray();

            foreach ($job_posts as $job_post) {
                if (in_array($job_post->profile_category_id, $user_profile_ids)) {
                    array_push($job_posts_to_send, $job_post);
                }
            }

            if (sizeof($job_posts_to_send) > 0) {
                Mail::to($user->email)->queue(new SendJobOffersMail($subject, $job_posts_to_send));
            }
        }
    }
}
