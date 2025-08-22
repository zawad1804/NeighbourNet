<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->string('category');
            $table->date('start_date');
            $table->string('start_time');
            $table->date('end_date')->nullable();
            $table->string('end_time')->nullable();
            $table->string('location');
            $table->text('location_details')->nullable();
            $table->string('image')->nullable();
            $table->integer('max_attendees')->nullable();
            $table->boolean('is_public')->default(true);
            $table->boolean('rsvp_enabled')->default(true);
            $table->timestamps();
        });

        Schema::create('event_attendees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->unique(['event_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_attendees');
        Schema::dropIfExists('events');
    }
};
