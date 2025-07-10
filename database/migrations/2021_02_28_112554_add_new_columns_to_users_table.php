<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('privacy')->after('secondary_notifications')->default(0);
            $table->string('nationality')->after('country')->nullable();
            $table->string('native_language')->after('landmark')->nullable();
            $table->string('birth_date')->after('address')->nullable();
            $table->string('company_name')->after('email_verified_at')->nullable();
            $table->string('company_website')->after('company_name')->nullable();
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
            $table->dropColumn('privacy', 'nationality', 'native_language', 'birth_date', 'company_name', 'company_website');
        });
    }
}
