<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdstatusToJobPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('job_posts', function (Blueprint $table) {
            $table->boolean('adstatus')->default(1)->comment('0 >Deactive, 1 > Active')->after('publish');
            $table->string('expirydt')->after('adstatus');
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
            $table->dropColumn('adstatus');
            $table->dropColumn('expirydt');
        });
    }
}
