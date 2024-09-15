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
        Schema::create('user_tier_research', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('province_id'); // Define province_id as unsignedBigInteger
            $table->string('username');
            $table->unsignedTinyInteger('user_tier'); // 1 or 2
            $table->string('source_con_schema')->nullable(); // Image URL or path
            $table->string('diesel_generator')->nullable(); // Boolean for diesel generator presence
            $table->string('motor')->nullable(); // Boolean for motor presence
            $table->integer('backup_power')->nullable(); // Boolean for backup power presence
            $table->string('backup_status')->nullable(); // Status of backup
            $table->string('contact')->nullable(); // Contact information
            $table->timestamps();

            // Set foreign key constraint
            $table->foreign('province_id')->references('id')->on('provinces')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_tier_research', function (Blueprint $table) {
            $table->dropForeign(['province_id']); // Drop the foreign key constraint
        });

        Schema::dropIfExists('user_tier_research');
    }
};
