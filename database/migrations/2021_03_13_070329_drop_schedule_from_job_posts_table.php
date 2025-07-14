<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropScheduleFromJobPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('job_posts', function (Blueprint $table) {
            $table->text('workschedule')->after('hoursperweek');   
            $table->dropColumn('schedule_mon');
            $table->dropColumn('schedule_tue');
            $table->dropColumn('schedule_wed');
            $table->dropColumn('schedule_thur');
            $table->dropColumn('schedule_fri');
            $table->dropColumn('schedule_sat');
            $table->dropColumn('schedule_sun');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('job_posts', function (Blueprint $table) {
            $table->dropColumn('workschedule');
            $table->text('schedule_mon');           
            $table->text('schedule_tue');           
            $table->text('schedule_wed');           
            $table->text('schedule_thur');           
            $table->text('schedule_fri');           
            $table->text('schedule_sat');           
            $table->text('schedule_sun');     
        });
    }
}
