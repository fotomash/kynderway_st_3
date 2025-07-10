<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsStatusToGetverifiedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('getverified', function (Blueprint $table) {
            //
            $table->integer('status')->after('reference_doc')->default(0)->comment('0=Pending, 1=Approve, 2=Reject');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('getverified', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
