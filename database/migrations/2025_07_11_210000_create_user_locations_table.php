<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('user_locations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('location_type')->default('home');
            $table->string('name');
            $table->string('address');
            $table->point('coordinates');
            $table->string('city');
            $table->string('postcode');
            $table->boolean('is_primary')->default(false);
            $table->date('active_from')->nullable();
            $table->date('active_until')->nullable();
            $table->timestamps();

            if (config('database.default') !== 'sqlite') {
                $table->spatialIndex('coordinates');
            }
            $table->index(['user_id', 'location_type']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_locations');
    }
};
