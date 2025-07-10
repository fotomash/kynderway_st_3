<?php

namespace App\Console\Commands;

use App\Mail\JobOfferNewsletter;
use App\Models\Job_Posts;
use App\Models\MailingJob;
use App\Models\User;
use Carbon\Carbon;
use Chatify\Http\Models\Message;
use Helper;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\Collection;

class MailingCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mailing:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send newsletter email';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $mailing = MailingJob::whereNull('startAt')->first();
            if ($mailing == null) {
                $this->info('No new job found');
                return 0;
            }
            $mailing->startAt = new \DateTime();
//        $mailing->save();

            $jobPosts = $this->getJobs($mailing->jobs);
            $users = json_decode($mailing->emails, true);
            $error = '';
            foreach ($users as $key => $user) {
                $users[$key]['done'] = true;
                $users[$key]['error'] = '';

                try {
                    $this->info('name '.$user['name'].' email '.$user['email']);
                    $this->info('progress '.$mailing->progress);

                    Mail::to($user['email'])->send(new JobOfferNewsletter(
                        [
                            'name' => $user['name'],
                            'email' => $user['email'],
                            'jobs' => $jobPosts
                        ]
                    ));

                    $mailing->progress += 1;
                    $mailing->save();
                } catch(\Exception $ex) {
                    $error .= $ex->getMessage() . PHP_EOL;
                    $users[$key]['done'] = false;
                    $users[$key]['error'] = $ex->getMessage();
                }
            }

            $mailing->finished = true;
            $mailing->finishedAt = new \DateTime();
            $mailing->error = $error;
            $mailing->emails = json_encode($users);

            $mailing->save();
        } catch (\Exception $ignored) {
        }
         return 0;
    }

    private function getJobs(string $jobsData): ?Collection
    {
        $jobs = json_decode($jobsData, true);

        return Job_Posts::with('userdetails', 'profilecategory')
            ->whereHas('userdetails')
            ->whereHas('profilecategory')
            ->whereIn('id', $jobs)
            ->get();
    }
}
