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
        Schema::create('log_activities', function (Blueprint $table) {
            $table->id();
            $table->string('subject')->nullable(); // Log subject
            $table->text('url')->nullable(); // URL of the request
            $table->string('method', 10)->nullable(); // HTTP method (GET, POST, etc.)
            $table->ipAddress('ip')->nullable(); // User's IP address
            $table->string('agent')->nullable(); // User agent string
            $table->unsignedBigInteger('user_id')->nullable(); // ID of the user performing the action
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_activities');
    }
};