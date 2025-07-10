<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMailingJob extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mailing_job', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->text('jobs');
            $table->text('emails');
            $table->integer('total');
            $table->integer('progress');
            $table->boolean('finished');
            $table->dateTime('createdAt');
            $table->dateTime('finishedAt')->nullable();
            $table->dateTime('startAt')->nullable();
            $table->text('error')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mailing_job');
    }
}
