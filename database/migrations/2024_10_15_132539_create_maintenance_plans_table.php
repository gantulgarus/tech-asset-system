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
        Schema::create('maintenance_plans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('equipment_id');  // Foreign key for equipment
            $table->integer('year');  // Year of the maintenance plan
            $table->unsignedBigInteger('work_type_id');  // Foreign key for work type (Major, Current Repair, etc.)
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('equipment_id')->references('id')->on('equipment')->onDelete('cascade');
            $table->foreign('work_type_id')->references('id')->on('work_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance_plans');
    }
};