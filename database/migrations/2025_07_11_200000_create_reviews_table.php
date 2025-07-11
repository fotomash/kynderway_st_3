<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_id');
            $table->foreignId('reviewer_id')->constrained('users');
            $table->foreignId('reviewee_id')->constrained('users');
            $table->enum('reviewer_type', ['parent', 'nanny']);
            $table->unsignedInteger('rating');
            $table->text('comment')->nullable();
            $table->json('rating_categories')->nullable();
            $table->boolean('would_recommend')->default(true);
            $table->boolean('would_hire_again')->default(true);
            $table->timestamps();

            $table->unique(['booking_id', 'reviewer_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('reviews');
    }
};
