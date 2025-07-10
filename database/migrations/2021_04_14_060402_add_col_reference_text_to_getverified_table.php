<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColReferenceTextToGetverifiedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('getverified', function (Blueprint $table) {
            $table->text('reference_text')->nullable()->after('identification_doc');
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
            $table->dropColumn('reference_text');
        });
    }
}
