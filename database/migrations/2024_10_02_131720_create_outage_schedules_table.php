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
        Schema::create('outage_schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('branch_id');
            $table->string('substation_line_equipment');
            $table->string('task');
            $table->datetime('start_date');
            $table->datetime('end_date');
            $table->string('type');
            $table->string('affected_users');
            $table->string('responsible_officer');
            $table->timestamps();

            // Add foreign key if branch_id references another table
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outage_schedules');
    }
};