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
        Schema::create('power_limit_adjustments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->unsignedBigInteger('station_id')->nullable();
            $table->string('output_name')->nullable();
            $table->timestamp('start_time')->nullable();
            $table->timestamp('end_time')->nullable();
            $table->integer('duration_minutes')->nullable();
            $table->float('duration_hours', 8, 2)->nullable();
            $table->float('voltage', 8, 2)->nullable();
            $table->float('amper', 8, 2)->nullable();
            $table->float('cosf', 5, 3)->nullable();
            $table->float('power', 10, 2)->nullable();
            $table->float('energy_not_supplied', 10, 2)->nullable();
            $table->integer('user_count')->nullable();
            $table->timestamps();

            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->foreign('station_id')->references('id')->on('stations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('power_limit_adjustments');
    }
};