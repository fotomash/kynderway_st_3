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
            ],          
            [
                "categoryname"       =>   "Maternity",
            ],
            [
                "categoryname"       =>   "Carer",
            ],
            [
                "categoryname"       =>   "Pet Carer",
            ],
            [
                "categoryname"       =>   "Cleaner",
            ],
            [
                "categoryname"       =>   "Housekeeper",
            ],
            [
                "categoryname"       =>   "Tutor",
            ],
           
        ];

        DB::table('profile_categories')->truncate();
        foreach($jobs as $job){
		    Profile_Categories::create($job);
		}
	}
}
