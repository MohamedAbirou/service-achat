<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
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
            $table->unsignedBigInteger('user_id')->nullable(); // Employee who made the request
            $table->unsignedBigInteger('product_id')->nullable(); // Product being requested
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
            $table->foreign('product_id')->references('id')->on('products')->nullOnDelete();
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
