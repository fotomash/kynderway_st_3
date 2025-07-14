<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Job_Types;

use DB;

class Job_TypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jobs = [
        	[
                "profile_id"       =>   "1",
                "jobtype" =>    "full time"
            ],
            [
                "profile_id"       =>   "1",
                "jobtype" =>    "part time"
            ],
            [
                "profile_id"       =>   "1",
                "jobtype" =>    "occasional"
            ],
            [
                "profile_id"       =>   "1",
                "jobtype" =>    "live in"
            ],
            [
                "profile_id"       =>   "1",
                "jobtype" =>    "live out"
            ],
            [
                "profile_id"       =>   "1",
                "jobtype" =>    "after school"
            ],
            [
                "profile_id"       =>   "1",
                "jobtype" =>    "babysitter"
            ],
            [
                "profile_id"       =>   "1",
                "jobtype" =>    "holiday"
            ],
            [
                "profile_id"       =>   "1",
                "jobtype" =>    "housekeeper/nanny"
            ],
            [
                "profile_id"       =>   "1",
                "jobtype" =>    "international"
            ],
            [
                "profile_id"       =>   "1",
                "jobtype" =>    "junior"
            ],
            [
                "profile_id"       =>   "1",
                "jobtype" =>    "PA/nanny"
            ],
            [
                "profile_id"       =>   "1",
                "jobtype" =>    "rota nanny"
            ],
            [
                "profile_id"       =>   "1",
                "jobtype" =>    "nanny share"
            ],
            [
                "profile_id"       =>   "1",
                "jobtype" =>    "special needs"
            ],
            [
                "profile_id"       =>   "1",
                "jobtype" =>    "weekend"
            ],
            [
                "profile_id"       =>   "1",
                "jobtype" =>    "emergency"
            ],
            [
                "profile_id"       =>   "1",
                "jobtype" =>    "24hr cover"
            ],
            [
                "profile_id"       =>   "1",
                "jobtype" =>    "au pair"
            ],
            [
                "profile_id"       =>   "2",
                "jobtype" =>    "occasional"
            ],
            [
                "profile_id"       =>   "2",
                "jobtype" =>    "live in"
            ],
            [
                "profile_id"       =>   "2",
                "jobtype" =>    "live out"
            ],
            [
                "profile_id"       =>   "2",
                "jobtype" =>    "full time"
            ],
            [
                "profile_id"       =>   "2",
                "jobtype" =>    "part time"
            ],
            [
                "profile_id"       =>   "2",
                "jobtype" =>    "sleep trainer"
            ],
            [
                "profile_id"       =>   "2",
                "jobtype" =>    "night nanny"
            ],
            [
                "profile_id"       =>   "2",
                "jobtype" =>    "weekend"
            ],
            [
                "profile_id"       =>   "2",
                "jobtype" =>    "emergency"
            ],
            [
                "profile_id"       =>   "2",
                "jobtype" =>    "international"
            ],
            [
                "profile_id"       =>   "2",
                "jobtype" =>    "24hr cover"
            ],
            [
                "profile_id"       =>   "3",
                "jobtype" =>    "day care"
            ],
            [
                "profile_id"       =>   "3",
                "jobtype" =>    "occasional"
            ],
            [
                "profile_id"       =>   "3",
                "jobtype" =>    "holiday"
            ],
            [
                "profile_id"       =>   "3",
                "jobtype" =>    "weekend"
            ],
            [
                "profile_id"       =>   "3",
                "jobtype" =>    "24hr cover"
            ],
            [
                "profile_id"       =>   "3",
                "jobtype" =>    "international"
            ],
            [
                "profile_id"       =>   "3",
                "jobtype" =>    "live in"
            ],
            [
                "profile_id"       =>   "3",
                "jobtype" =>    "live out"
            ],
            [
                "profile_id"       =>   "3",
                "jobtype" =>    "full time"
            ],
            [
                "profile_id"       =>   "3",
                "jobtype" =>    "part time"
            ],
            [
                "profile_id"       =>   "4",
                "jobtype" =>    "day care"
            ],
            [
                "profile_id"       =>   "4",
                "jobtype" =>    "occasional"
            ],
            [
                "profile_id"       =>   "4",
                "jobtype" =>    "overnight"
            ],
            [
                "profile_id"       =>   "4",
                "jobtype" =>    "weekend"
            ],
            [
                "profile_id"       =>   "4",
                "jobtype" =>    "holiday"
            ],
            [
                "profile_id"       =>   "4",
                "jobtype" =>    "emergency"
            ],
            [
                "profile_id"       =>   "4",
                "jobtype" =>    "24hr cover"
            ],
            [
                "profile_id"       =>   "4",
                "jobtype" =>    "home visits (drop-in)"
            ],
            [
                "profile_id"       =>   "4",
                "jobtype" =>    "house sitting"
            ],
            [
                "profile_id"       =>   "5",
                "jobtype" =>    "full time"
            ],
            [
                "profile_id"       =>   "5",
                "jobtype" =>    "part time"
            ],
            [
                "profile_id"       =>   "5",
                "jobtype" =>    "occasional"
            ],
            [
                "profile_id"       =>   "5",
                "jobtype" =>    "emergency"
            ],
            [
                "profile_id"       =>   "5",
                "jobtype" =>    "live in"
            ],
            [
                "profile_id"       =>   "5",
                "jobtype" =>    "live out"
            ],
            [
                "profile_id"       =>   "6",
                "jobtype" =>    "full time"
            ],
            [
                "profile_id"       =>   "6",
                "jobtype" =>    "part time"
            ],
            [
                "profile_id"       =>   "6",
                "jobtype" =>    "occasional"
            ],
            [
                "profile_id"       =>   "6",
                "jobtype" =>    "emergency"
            ],
            [
                "profile_id"       =>   "6",
                "jobtype" =>    "live in"
            ],
            [
                "profile_id"       =>   "6",
                "jobtype" =>    "live out"
            ],
            [
                "profile_id"       =>   "7",
                "jobtype" =>    "occasional"
            ],
            [
                "profile_id"       =>   "7",
                "jobtype" =>    "weekend"
            ],
            [
                "profile_id"       =>   "7",
                "jobtype" =>    "maths"
            ],
            [
                "profile_id"       =>   "7",
                "jobtype" =>    "physics"
            ],
            [
                "profile_id"       =>   "7",
                "jobtype" =>    "biology"
            ],
            [
                "profile_id"       =>   "7",
                "jobtype" =>    "history"
            ],
            [
                "profile_id"       =>   "7",
                "jobtype" =>    "english"
            ],
            [
                "profile_id"       =>   "7",
                "jobtype" =>    "spanish"
            ],
            [
                "profile_id"       =>   "7",
                "jobtype" =>    "french"
            ],
            [
                "profile_id"       =>   "7",
                "jobtype" =>    "portuguese"
            ],
            [
                "profile_id"       =>   "7",
                "jobtype" =>    "russian"
            ],
            [
                "profile_id"       =>   "7",
                "jobtype" =>    "german"
            ],
             [
                "profile_id"       =>   "7",
                "jobtype" =>    "chello"
            ],
             [
                "profile_id"       =>   "7",
                "jobtype" =>    "piano"
            ],
             [
                "profile_id"       =>   "7",
                "jobtype" =>    "music"
            ],
             [
                "profile_id"       =>   "7",
                "jobtype" =>    "dance"
            ],
             [
                "profile_id"       =>   "7",
                "jobtype" =>    "yoga"
            ],
            [
                "profile_id"       =>   "5",
                "jobtype" =>    "regular"
            ],
        ];

        DB::table('job_types')->truncate();
        foreach($jobs as $job){
		    Job_Types::create($job);
		}


    }
}
