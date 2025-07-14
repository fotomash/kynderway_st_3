<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_posts', function (Blueprint $table) {
             $table->increments('id');            
            $table->integer('user_id');
            $table->integer('profile_category_id');
            $table->string('jobtypes');
            $table->string('jobtitle');
            $table->string('postalcode');
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('landmark');
            $table->string('address');
            $table->string('jobduration');
            $table->string('position');
            $table->string('workwith');           
            $table->string('req_language'); 
            $table->string('pref_language'); 
            $table->string('asap');
            $table->string('start_date');
            $table->string('payamountcurrency');
            $table->decimal('payamount_from', 15);
            $table->decimal('payamount_to', 15);
            $table->string('payfrequency');           
            $table->string('hoursperweek');           
            $table->text('schedule_mon');           
            $table->text('schedule_tue');           
            $table->text('schedule_wed');           
            $table->text('schedule_thur');           
            $table->text('schedule_fri');           
            $table->text('schedule_sat');           
            $table->text('schedule_sun');               
            $table->text('job_details');
            $table->boolean('publish')->default(0)->comment('0 >Unpublish, 1 > Publish');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_posts');
    }
}
