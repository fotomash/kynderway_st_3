<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profile_posts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('provider_id');
            $table->integer('profile_category_id');
            $table->string('job_duration');
            $table->string('currency');
            $table->decimal('payamount', 15);
            $table->string('payfrequency');
            $table->string('jobtypes');
            $table->string('experience1');
            $table->string('experience2');
            $table->string('workwith');
            $table->string('worksector');
            $table->boolean('carvalue');
            $table->boolean('licensevalue');
            $table->boolean('qualificationsvalue');
            $table->boolean('recordvalue');
            $table->boolean('aidvalue');
            $table->boolean('refvalue');
            $table->text('edu_description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profile_posts');
    }
}
