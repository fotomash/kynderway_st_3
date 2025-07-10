<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixColAvatarInUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('avatar');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('avatar')->default('avatar.png')->after('email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('avatar');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('avatar')->default(config('chatify.user_avatar.default'))->after('email');
        });
    }
}
