<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAssignJobPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('job_posts', function (Blueprint $table) {
            $table->text('user_notes')->after('marketing')->nullable();
            $table->string('assigned_user_id')->nullable();
            $table->string('deleted_by')->nullable();
            $table->string('deleted_type')->nullable();
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
            $table->dropColumn('user_notes', 'assigned_user_id', 'deleted_by', 'deleted_type');
        });
    }
}
