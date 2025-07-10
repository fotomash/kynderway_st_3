<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReportReasonColumnInUserConnections extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_connections', function (Blueprint $table) {
            $table->text('report_reason')->nullable()->after('report');
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
            $table->dropColumn('report_reason');
        });
    }
}
