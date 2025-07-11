<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('unlocked_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('nanny_id')->constrained('users')->onDelete('cascade');
            $table->integer('credits_used');
            $table->timestamp('unlocked_at');
            $table->timestamp('expires_at')->nullable();
            $table->boolean('has_booked')->default(false);
            $table->timestamps();

            $table->unique(['parent_id', 'nanny_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('unlocked_profiles');
    }
};
