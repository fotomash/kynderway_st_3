<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Specialities;

use DB;

class SpecialitiesSeeder extends Seeder
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
                "profile_category_id"       =>   "1",
                "name" =>    "newborn (up to 12 months)"
            ],
            [
                "profile_category_id"       =>   "1",
                "name" =>    "toddler (1-3 years)"
            ],
            [
                "profile_category_id"       =>   "1",
                "name" =>    "early school (4-6 years)	"
            ],
            [
                "profile_category_id"       =>   "1",
                "name" =>    "primary school (7-12 years)"
            ],
            [
                "profile_category_id"       =>   "1",
                "name" =>    "teenager (12+years)"
            ],
            [
                "profile_category_id"       =>   "1",
                "name" =>    "special needs"
            ],
             [
                "profile_category_id"       =>   "2",
                "name" =>    "newborn"
            ],
             [
                "profile_category_id"       =>   "2",
                "name" =>    "born premature"
            ],
             [
                "profile_category_id"       =>   "2",
                "name" =>    "twins"
            ],
             [
                "profile_category_id"       =>   "2",
                "name" =>    "triplets"
            ],
            [
                "profile_category_id"       =>   "3",
                "name" =>    "dementia"
            ],
             [
                "profile_category_id"       =>   "3",
                "name" =>    "parkinson's"
            ],
             [
                "profile_category_id"       =>   "3",
                "name" =>    "alzheimer's"
            ],
             [
                "profile_category_id"       =>   "3",
                "name" =>    "sensory impairment"
            ],
             [
                "profile_category_id"       =>   "3",
                "name" =>    "physical disability"
            ],
             [
                "profile_category_id"       =>   "3",
                "name" =>    "diabetes"
            ],
             [
                "profile_category_id"       =>   "3",
                "name" =>    "elderly"
            ],
            [
                "profile_category_id"       =>   "4",
                "name" =>    "dog"
            ],
            [
                "profile_category_id"       =>   "4",
                "name" =>    "cat"
            ],
            [
                "profile_category_id"       =>   "4",
                "name" =>    "farm animal"
            ],
            [
                "profile_category_id"       =>   "4",
                "name" =>    "reptile"
            ],
            [
                "profile_category_id"       =>   "4",
                "name" =>    "exotic"
            ],
            [
                "profile_category_id"       =>   "4",
                "name" =>    "bird"
            ],
            [
                "profile_category_id"       =>   "4",
                "name" =>    "fish"
            ],
            [
                "profile_category_id"       =>   "4",
                "name" =>    "amphibian"
            ],
             [
                "profile_category_id"       =>   "4",
                "name" =>    "spiders & insects"
            ],
            [
                "profile_category_id"       =>   "5",
                "name" =>    "private household"
            ],
            [
                "profile_category_id"       =>   "5",
                "name" =>    "flat"
            ],
            [
                "profile_category_id"       =>   "5",
                "name" =>    "restaurant"
            ],
            [
                "profile_category_id"       =>   "5",
                "name" =>    "hotel"
            ],
            [
                "profile_category_id"       =>   "5",
                "name" =>    "office"
            ],
            [
                "profile_category_id"       =>   "5",
                "name" =>    "end of tenancy cleaning "
            ],
            [
                "profile_category_id"       =>   "5",
                "name" =>    "spring cleaning"
            ],
            [
                "profile_category_id"       =>   "5",
                "name" =>    "cleaning after building work"
            ],
            [
                "profile_category_id"       =>   "6",
                "name" =>    "private household"
            ],
            [
                "profile_category_id"       =>   "6",
                "name" =>    "flat"
            ],
            [
                "profile_category_id"       =>   "7",
                "name" =>    "primary school"
            ],
            [
                "profile_category_id"       =>   "7",
                "name" =>    "a-levels"
            ],
            [
                "profile_category_id"       =>   "7",
                "name" =>    "adults"
            ],
            [
                "profile_category_id"       =>   "7",
                "name" =>    "secondary school"
            ],
            [
                "profile_category_id"       =>   "7",
                "name" =>    "university"
            ],
            [
                "profile_category_id"       =>   "7",
                "name" =>    "special needs"
            ],

        ];

        DB::table('specialities')->truncate();
        foreach ($jobs as $job) {
            Specialities::create($job);
        }
    }
}
