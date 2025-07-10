<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Profile_Categories;

use DB;

class Profile_CategoriesSeeder extends Seeder
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
                "categoryname"       =>   "Nanny",
                "slug"               =>   "nanny",
            ],
            [
                "categoryname"       =>   "Maternity Nurse",
                "slug"               =>   "maternity-nurse",
            ],
            [
                "categoryname"       =>   "Carer",
                "slug"               =>   "carer",
            ],
            [
                "categoryname"       =>   "Pet Carer",
                "slug"               =>   "pet-carer",
            ],
            [
                "categoryname"       =>   "Cleaner",
                "slug"               =>   "cleaner",
            ],
            [
                "categoryname"       =>   "Housekeeper",
                "slug"               =>   "housekeeper",
            ],
            [
                "categoryname"       =>   "Tutor",
                "slug"               =>   "tutor",
            ],

        ];

        DB::table('profile_categories')->truncate();
        foreach ($jobs as $job) {
            Profile_Categories::create($job);
        }
    }
}
