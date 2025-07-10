<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusProfilePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('profile_posts', function (Blueprint $table) {
            $table->boolean('status')->default(1)->comment('0 > Suspend, 1 > Active')->after('edu_description');
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
            $table->dropColumn('status');
        });
    }
}
