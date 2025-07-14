<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProfilesColumnToUserTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone_code')->after('client_type')->nullable();
            $table->string('phone')->after('phone_code')->nullable();
            $table->integer('secondary_notifications')->after('phone')->default(0);
            $table->string('country')->after('secondary_notifications')->nullable();
            $table->string('state')->after('country')->nullable();
            $table->string('city')->after('state')->nullable();
            $table->string('postal_code')->after('city')->nullable();
            $table->string('landmark')->after('postal_code')->nullable();
            $table->longText('address')->after('landmark')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('phone_code', 'phone', 'secondary_notifications', 'country', 'state', 'city', 'postal_code', 'landmark', 'address');
        });
    }

}
