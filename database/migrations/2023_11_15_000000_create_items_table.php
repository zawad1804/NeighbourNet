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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('category');
            $table->enum('type', ['for-sale', 'free', 'rent', 'wanted']);
            $table->decimal('price', 10, 2)->default(0);
            $table->string('condition')->nullable();
            $table->string('brand')->nullable();
            $table->string('image')->nullable();
            $table->json('gallery')->nullable();
            $table->string('location');
            $table->enum('status', ['available', 'pending', 'sold'])->default('available');
            $table->boolean('hide_location')->default(false);
            $table->boolean('contact_message')->default(true);
            $table->boolean('contact_phone')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
