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
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable(); // Title of the request
            $table->text('description')->nullable(); // Description of the request
            $table->integer('quantity'); // Quantity requested
            $table->decimal('budget', 10, 2)->nullable(); // Budget for the request
            $table->enum('status', ['pending', 'approved', 'declined'])->default('pending');
            $table->string('department')->nullable();  // Department of the user who made the request
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Employee who made the request
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Product being requested
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requests');
    }
};
