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
        Schema::create('power_outages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('station_id');
            $table->unsignedBigInteger('equipment_id');
            $table->unsignedBigInteger('protection_id');
            $table->timestamp('start_time');
            $table->timestamp('end_time')->nullable();
            $table->integer('duration')->nullable(); // duration in minutes
            $table->string('weather')->nullable();
            $table->unsignedBigInteger('cause_outage_id');
            $table->float('current_voltage')->nullable();
            $table->float('current_amper')->nullable();
            $table->float('cosf')->nullable(); // power factor
            $table->float('ude')->nullable(); // under-distributed electricity
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            // Adding foreign key constraints (if applicable)
            $table->foreign('station_id')->references('id')->on('stations')->onDelete('cascade');
            $table->foreign('equipment_id')->references('id')->on('equipment')->onDelete('cascade');
            $table->foreign('protection_id')->references('id')->on('protections')->onDelete('cascade');
            $table->foreign('cause_outage_id')->references('id')->on('cause_outages')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('power_outages');
    }
};
