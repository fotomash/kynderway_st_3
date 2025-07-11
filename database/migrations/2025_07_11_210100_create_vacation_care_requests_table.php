<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('vacation_care_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->constrained('users');
            $table->string('destination_address');
            $table->point('destination_coordinates');
            $table->string('destination_city');
            $table->string('accommodation_type');
            $table->date('start_date');
            $table->date('end_date');
            $table->json('care_schedule');
            $table->boolean('local_nanny_preferred')->default(true);
            $table->boolean('traveling_nanny_considered')->default(false);
            $table->decimal('travel_expense_budget', 10, 2)->nullable();
            $table->text('special_requirements')->nullable();
            $table->enum('status', ['draft', 'searching', 'matched', 'completed', 'cancelled']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vacation_care_requests');
    }
};
