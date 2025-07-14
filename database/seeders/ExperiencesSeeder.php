<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Experiences;

use DB;

class ExperiencesSeeder extends Seeder
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
                "exp_name" =>    "afterschool activities"
            ],          
            [
                "profile_category_id"       =>   "1",
                "exp_name" =>    "homework"
            ],
            [
                "profile_category_id"       =>   "1",
                "exp_name" =>    "school/nursery pickups"
            ],
            [
                "profile_category_id"       =>   "1",
                "exp_name" =>    "organising playdates"
            ],
            [
                "profile_category_id"       =>   "1",
                "exp_name" =>    "children's laundry"
            ],
            [
                "profile_category_id"       =>   "1",
                "exp_name" =>    "bathing"
            ],
            [
                "profile_category_id"       =>   "1",
                "exp_name" =>    "planning meals"
            ],
            [
                "profile_category_id"       =>   "1",
                "exp_name" =>    "preparing meals"
            ],
            [
                "profile_category_id"       =>   "1",
                "exp_name" =>    "arranging outings"
            ],
            [
                "profile_category_id"       =>   "1",
                "exp_name" =>    "educational activities"
            ],
             [
                "profile_category_id"       =>   "1",
                "exp_name" =>    "arts and crafts"
            ],
             [
                "profile_category_id"       =>   "1",
                "exp_name" =>    "changing diapers"
            ],
             [
                "profile_category_id"       =>   "1",
                "exp_name" =>    "potty training"
            ],
            [
                "profile_category_id"       =>   "1",
                "exp_name" =>    "light housekeeping"
            ],    
            [
                "profile_category_id"       =>   "1",
                "exp_name" =>    "reading to children"
            ],   
            [
                "profile_category_id"       =>   "1",
                "exp_name" =>    "putting to bed"
            ],    
            [
                "profile_category_id"       =>   "1",
                "exp_name" =>    "creating routine"
            ],    
            [
                "profile_category_id"       =>   "1",
                "exp_name" =>    "rooms tidying"
            ],    
            [
                "profile_category_id"       =>   "1",
                "exp_name" =>    "administering medication"
            ],    
            [
                "profile_category_id"       =>   "1",
                "exp_name" =>    "intellectual stimulation"
            ],    
            [
                "profile_category_id"       =>   "1",
                "exp_name" =>    "Montessori"
            ],    
            [
                "profile_category_id"       =>   "1",
                "exp_name" =>    "Driving"
            ],    
            [
                "profile_category_id"       =>   "1",
                "exp_name" =>    "organizing bedrooms/toys"
            ],    



            [
                "profile_category_id"       =>   "2",
                "exp_name" =>    "provide emotional support"
            ],          
            [
                "profile_category_id"       =>   "2",
                "exp_name" =>    "establishing routine"
            ],
            [
                "profile_category_id"       =>   "2",
                "exp_name" =>    "feeding the baby"
            ],
            [
                "profile_category_id"       =>   "2",
                "exp_name" =>    "settling the baby "
            ],
            [
                "profile_category_id"       =>   "2",
                "exp_name" =>    "advice on the use of equipment"
            ],
            [
                "profile_category_id"       =>   "2",
                "exp_name" =>    "advice on breast or bottle feeding "
            ],
            [
                "profile_category_id"       =>   "2",
                "exp_name" =>    "sleep training"
            ],
            [
                "profile_category_id"       =>   "2",
                "exp_name" =>    "dealing with allergies"
            ],
            [
                "profile_category_id"       =>   "2",
                "exp_name" =>    "reflux"
            ],
            [
                "profile_category_id"       =>   "2",
                "exp_name" =>    "sterilise bottles and equipment"
            ],
            [
                "profile_category_id"       =>   "2",
                "exp_name" =>    "administering medication"
            ],
            [
                "profile_category_id"       =>   "2",
                "exp_name" =>    "bathing"
            ],
           
            [
                "profile_category_id"       =>   "2",
                "exp_name" =>    "maintaining nursery"
            ],
            [
                "profile_category_id"       =>   "2",
                "exp_name" =>    "putting to sleep"
            ],
            [
                "profile_category_id"       =>   "2",
                "exp_name" =>    "baby's laundry"
            ],
            [
                "profile_category_id"       =>   "2",
                "exp_name" =>    "sorting out clothes"
            ],
                         
          
          
            [
                "profile_category_id"       =>   "3",
                "exp_name" =>    "assiting with daily activities"
            ],          
            [
                "profile_category_id"       =>   "3",
                "exp_name" =>    "cooking"
            ],
            [
                "profile_category_id"       =>   "3",
                "exp_name" =>    "blood pressure monitoring"
            ],
            [
                "profile_category_id"       =>   "3",
                "exp_name" =>    "heart rate monitoring"
            ],
            [
                "profile_category_id"       =>   "3",
                "exp_name" =>    "blood glucose testing and monitoring"
            ],
            [
                "profile_category_id"       =>   "3",
                "exp_name" =>    "nutrition"
            ],
            [
                "profile_category_id"       =>   "3",
                "exp_name" =>    "emotional support"
            ],
            [
                "profile_category_id"       =>   "3",
                "exp_name" =>    "bathing"
            ],
            [
                "profile_category_id"       =>   "3",
                "exp_name" =>    "feeding"
            ],
            [
                "profile_category_id"       =>   "3",
                "exp_name" =>    "dressing"
            ],
             [
                "profile_category_id"       =>   "3",
                "exp_name" =>    "assisting with medication"
            ],
             [
                "profile_category_id"       =>   "3",
                "exp_name" =>    "housekeeping tasks"
            ],
             [
                "profile_category_id"       =>   "3",
                "exp_name" =>    "intellectual stimulation"
            ],
            [
                "profile_category_id"       =>   "3",
                "exp_name" =>    "outdoor walks"
            ],

            [
                "profile_category_id"       =>   "3",
                "exp_name" =>    "driving/transporting"
            ],          
            [
                "profile_category_id"       =>   "3",
                "exp_name" =>    "medication mangement"
            ],
            [
                "profile_category_id"       =>   "3",
                "exp_name" =>    "assistance with personal hygiene"
            ],
            [
                "profile_category_id"       =>   "3",
                "exp_name" =>    "shopping"
            ],          
            [
                "profile_category_id"       =>   "3",
                "exp_name" =>    "light gardening"
            ],  



            [
                "profile_category_id"       =>   "4",
                "exp_name" =>    "feeding"
            ],
            [
                "profile_category_id"       =>   "4",
                "exp_name" =>    "brushing"
            ],
            [
                "profile_category_id"       =>   "4",
                "exp_name" =>    "nutrition"
            ],
            [
                "profile_category_id"       =>   "4",
                "exp_name" =>    "walking"
            ],
            [
                "profile_category_id"       =>   "4",
                "exp_name" =>    "grooming"
            ],
            [
                "profile_category_id"       =>   "4",
                "exp_name" =>    "cleaning after pet"
            ],
            [
                "profile_category_id"       =>   "4",
                "exp_name" =>    "animal CPR and first aid"
            ],
             [
                "profile_category_id"       =>   "4",
                "exp_name" =>    "administering medication"
            ],
             [
                "profile_category_id"       =>   "4",
                "exp_name" =>    "cleaning litter boxes"
            ],
             [
                "profile_category_id"       =>   "4",
                "exp_name" =>    "cleaning cages or bedding"
            ],
            [
                "profile_category_id"       =>   "4",
                "exp_name" =>    "cleaning tanks"
            ],

            [
                "profile_category_id"       =>   "5",
                "exp_name" =>    "dusting"
            ],          
            [
                "profile_category_id"       =>   "5",
                "exp_name" =>    "vacuuming"
            ],
            [
                "profile_category_id"       =>   "5",
                "exp_name" =>    "mopping"
            ],
            [
                "profile_category_id"       =>   "5",
                "exp_name" =>    "cleaning bathrooms"
            ],
            [
                "profile_category_id"       =>   "5",
                "exp_name" =>    "window cleaning"
            ],
            [
                "profile_category_id"       =>   "5",
                "exp_name" =>    "dishwashing"
            ],
            [
                "profile_category_id"       =>   "5",
                "exp_name" =>    "ironing"
            ],
            [
                "profile_category_id"       =>   "5",
                "exp_name" =>    "waste disposal"
            ],
            [
                "profile_category_id"       =>   "5",
                "exp_name" =>    "stock and maintain cleaning supplies"
            ],
            [
                "profile_category_id"       =>   "5",
                "exp_name" =>    "polish cutlery"
            ],
             [
                "profile_category_id"       =>   "5",
                "exp_name" =>    "polish silver"
            ],
             [
                "profile_category_id"       =>   "5",
                "exp_name" =>    "change beddings"
            ],
             [
                "profile_category_id"       =>   "5",
                "exp_name" =>    "simple gardening"
            ],
            [
                "profile_category_id"       =>   "5",
                "exp_name" =>    "dirty linens transport"
            ],

            [
                "profile_category_id"       =>   "5",
                "exp_name" =>    "surface sanitising"
            ],          

            [
                "profile_category_id"       =>   "6",
                "exp_name" =>    "dusting"
            ],
            [
                "profile_category_id"       =>   "6",
                "exp_name" =>    "vacuuming"
            ],
            [
                "profile_category_id"       =>   "6",
                "exp_name" =>    "mopping"
            ],
            [
                "profile_category_id"       =>   "6",
                "exp_name" =>    "cleaning bathrooms"
            ],
            [
                "profile_category_id"       =>   "6",
                "exp_name" =>    "window cleaning"
            ],
            [
                "profile_category_id"       =>   "6",
                "exp_name" =>    "dishwashing"
            ],
            [
                "profile_category_id"       =>   "6",
                "exp_name" =>    "ironing"
            ],
            [
                "profile_category_id"       =>   "6",
                "exp_name" =>    "waste disposal"
            ],
            [
                "profile_category_id"       =>   "6",
                "exp_name" =>    "stock and maintain cleaning supplies"
            ],
             [
                "profile_category_id"       =>   "6",
                "exp_name" =>    "polish cutlery"
            ],
             [
                "profile_category_id"       =>   "6",
                "exp_name" =>    "polish silver"
            ],
             [
                "profile_category_id"       =>   "6",
                "exp_name" =>    "change beddings"
            ],
            [
                "profile_category_id"       =>   "6",
                "exp_name" =>    "running errands"
            ],   
            [
                "profile_category_id"       =>   "6",
                "exp_name" =>    "food shopping"
            ],    
             [
                "profile_category_id"       =>   "6",
                "exp_name" =>    "helping with children"
            ],
             [
                "profile_category_id"       =>   "6",
                "exp_name" =>    "organising inside cabinets"
            ],
             [
                "profile_category_id"       =>   "6",
                "exp_name" =>    "laundry"
            ],


            [
                "profile_category_id"       =>   "7",
                "exp_name" =>    "online tutoring"
            ],          
            [
                "profile_category_id"       =>   "7",
                "exp_name" =>    "exam preparation"
            ],
            [
                "profile_category_id"       =>   "7",
                "exp_name" =>    "homework help"
            ],
            [
                "profile_category_id"       =>   "7",
                "exp_name" =>    "special needs tutoring"
            ],
            [
                "profile_category_id"       =>   "7",
                "exp_name" =>    "group tutoring"
            ],
            [
                "profile_category_id"       =>   "7",
                "exp_name" =>    "homeschooling"
            ],
        ];

        DB::table('experiences')->truncate();
        foreach($jobs as $job){
		   Experiences::create($job);
		}
    }
}
