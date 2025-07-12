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
        });

        foreach (['schedule_mon', 'schedule_tue', 'schedule_wed', 'schedule_thur', 'schedule_fri', 'schedule_sat', 'schedule_sun'] as $column) {
            if (Schema::hasColumn('job_posts', $column)) {
                Schema::table('job_posts', function (Blueprint $table) use ($column) {
                    $table->dropColumn($column);
                });
            }
        }
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
        });

        foreach (['schedule_mon', 'schedule_tue', 'schedule_wed', 'schedule_thur', 'schedule_fri', 'schedule_sat', 'schedule_sun'] as $column) {
            if (!Schema::hasColumn('job_posts', $column)) {
                Schema::table('job_posts', function (Blueprint $table) use ($column) {
                    $table->text($column)->nullable();
                });
            }
        }
    }
}
