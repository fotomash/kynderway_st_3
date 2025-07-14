<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserConnectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_connections', function (Blueprint $table) {
            $table->increments('id');            
            $table->integer('job_userid');
            $table->integer('provider_id');
            $table->integer('jobappliedid');
            $table->integer('profilecategoryid');
            $table->string('clienttype');
            $table->boolean('jobconnect')->default(0)->comment('0=busi/ind connect pending, 1 =connection done');
            $table->boolean('providerconnect')->default(0)->comment('0=provider connect pending, 1 =connection done');
            $table->boolean('fullconnect')->default(0)->comment('0=anyside connect pending, 1 =connection done');        
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
        Schema::dropIfExists('user_connections');
    }
}
