<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGetverifiedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('getverified', function (Blueprint $table) {            
            $table->increments('id');            
            $table->integer('provider_id');
            $table->string('identification_type');
            $table->string('identification_doc');
            $table->integer('adv_check')->default(0);
            $table->string('reference_doc');
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
        Schema::dropIfExists('getverified');
    }
}
