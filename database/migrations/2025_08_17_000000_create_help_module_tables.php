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
        // Help Categories Table
        Schema::create('help_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('icon')->nullable();
            $table->text('description');
            $table->boolean('requires_verification')->default(false);
            $table->boolean('allows_emergency_requests')->default(true);
            $table->boolean('is_active')->default(true);
            $table->integer('display_order')->default(0);
            $table->timestamps();
        });

        // Skills/Tags Table
        Schema::create('help_skills', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->boolean('requires_verification')->default(false);
            $table->foreignId('help_category_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });

        // Help Requests Table
        Schema::create('help_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('help_category_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('description');
            $table->string('location')->nullable();
            $table->boolean('is_remote')->default(false);
            $table->dateTime('scheduled_at')->nullable();
            $table->dateTime('ends_at')->nullable();
            $table->boolean('is_recurring')->default(false);
            $table->string('recurrence_pattern')->nullable(); // daily, weekly, monthly, etc.
            $table->boolean('is_emergency')->default(false);
            $table->enum('status', ['open', 'assigned', 'in_progress', 'completed', 'cancelled'])->default('open');
            $table->timestamps();
        });

        // Help Request Skills
        Schema::create('help_request_skill', function (Blueprint $table) {
            $table->id();
            $table->foreignId('help_request_id')->constrained()->cascadeOnDelete();
            $table->foreignId('help_skill_id')->constrained('help_skills')->cascadeOnDelete();
            $table->timestamps();
        });

        // Help Offers Table (for helpers offering to help)
        Schema::create('help_offers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('help_request_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->text('message')->nullable();
            $table->enum('status', ['pending', 'accepted', 'rejected', 'withdrawn'])->default('pending');
            $table->timestamps();
        });

        // Helper Availability
        Schema::create('helper_availabilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->enum('status', ['available_now', 'available_today', 'available_this_week', 'busy']);
            $table->dateTime('available_from')->nullable();
            $table->dateTime('available_until')->nullable();
            $table->boolean('available_for_emergency')->default(false);
            $table->json('recurring_schedule')->nullable(); // JSON array of weekdays and time ranges
            $table->timestamps();
        });

        // Helper Skills
        Schema::create('helper_skill', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('help_skill_id')->constrained('help_skills')->cascadeOnDelete();
            $table->boolean('is_verified')->default(false);
            $table->date('verified_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // Helper Categories (which categories a helper is willing to help with)
        Schema::create('helper_category', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('help_category_id')->constrained()->cascadeOnDelete();
            $table->boolean('is_primary')->default(false);
            $table->timestamps();
        });

        // Help Messages
        Schema::create('help_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('help_request_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->text('message');
            $table->json('attachments')->nullable();
            $table->boolean('is_system_message')->default(false);
            $table->timestamps();
        });

        // Help Feedback
        Schema::create('help_feedback', function (Blueprint $table) {
            $table->id();
            $table->foreignId('help_request_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->comment('User who left the feedback');
            $table->foreignId('helper_id')->constrained('users')->comment('User who provided the help');
            $table->integer('punctuality_rating')->nullable();
            $table->integer('communication_rating')->nullable();
            $table->integer('quality_rating')->nullable();
            $table->integer('friendliness_rating')->nullable();
            $table->integer('overall_rating');
            $table->text('comments')->nullable();
            $table->boolean('is_anonymous')->default(false);
            $table->text('helper_response')->nullable();
            $table->timestamps();
        });

        // Helper Achievements
        Schema::create('helper_achievements', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('icon')->nullable();
            $table->string('badge_image')->nullable();
            $table->string('achievement_type');
            $table->integer('threshold')->default(1);
            $table->json('criteria')->nullable();
            $table->timestamps();
        });

        // User Achievements
        Schema::create('user_achievement', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('helper_achievement_id')->constrained()->cascadeOnDelete();
            $table->dateTime('achieved_at');
            $table->integer('progress')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_achievement');
        Schema::dropIfExists('helper_achievements');
        Schema::dropIfExists('help_feedback');
        Schema::dropIfExists('help_messages');
        Schema::dropIfExists('helper_category');
        Schema::dropIfExists('helper_skill');
        Schema::dropIfExists('helper_availabilities');
        Schema::dropIfExists('help_offers');
        Schema::dropIfExists('help_request_skill');
        Schema::dropIfExists('help_requests');
        Schema::dropIfExists('help_skills');
        Schema::dropIfExists('help_categories');
    }
};
