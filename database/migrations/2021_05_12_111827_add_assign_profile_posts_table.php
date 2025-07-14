<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAssignProfilePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('profile_posts', function (Blueprint $table) {
            $table->text('user_notes')->nullable();
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
        Schema::table('profile_posts', function (Blueprint $table) {
            $table->dropColumn('user_notes','assigned_user_id','deleted_by','deleted_type');
        });
    }
}
