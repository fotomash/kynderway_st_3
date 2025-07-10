<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\User_Connections;
use Carbon\Carbon;
use Chatify\Http\Models\Message;
use Illuminate\Console\Command;
use Helper;
use Illuminate\Support\Facades\DB;

class EmailMessagesCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:messages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email of unread messages to users';

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
        // Find the time of before 2 minutes
        $beforeOneMinutes = Carbon::now()->subMinutes(1);

        $messages = Message::select('to_id', 'reference_id', 'from_id', DB::raw('COUNT(*)'))
                ->where([
                    ['seen', '=', 0],
                    ['notify', '=', 0],
                    ['created_at', '<=', $beforeOneMinutes->toDateTimeString()]
                ])->groupBy('from_id', 'to_id', 'reference_id')->get();

        foreach ($messages as $message) {
            // Find to user data
            $toUser = User::find($message->to_id);

            if ($toUser->secondary_notifications == 1) {
                // Find from user data
                $fromUser = User::find($message->from_id);

                $requiredData = [];
                $requiredData['toUsername'] = $toUser['name'];
                $requiredData['toEmail'] = $toUser['email'];
                $requiredData['fromUsername'] = $fromUser['name'];

                // Send mail
                if (Helper::unreadMessageMail($requiredData) != null) {
                    $this->info('Something went wrong. Could not send email of new messages');
                    break;
                }

                Message::where([
                    ['to_id', $message->to_id],
                    ['created_at', '<=', $beforeOneMinutes->toDateTimeString()]
                ])->update([
                    'notify' => 1
                ]);
            }
        }

        $this->info('New messages email sent successfully to all users.');
    }
}
