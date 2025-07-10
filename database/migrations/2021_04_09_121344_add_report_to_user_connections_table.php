<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReportToUserConnectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_connections', function (Blueprint $table) {
            $table->boolean('report')->default(0)->comment('0 >Not reported, 1 > Reported')->after('fullconnect');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_connections', function (Blueprint $table) {
            //
        });
    }
}
