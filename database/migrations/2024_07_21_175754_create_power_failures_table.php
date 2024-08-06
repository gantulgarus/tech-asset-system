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
        Schema::create('power_failures', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('station_id');
            $table->unsignedBigInteger('equipment_id');
            $table->date('failure_date');
            $table->string('detector_name');
            $table->text('failure_detail');
            $table->string('notified_name');
            $table->text('action_taken');
            $table->string('fixer_name');
            $table->string('inspector_name');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('station_id')->references('id')->on('stations')->onDelete('cascade');
            $table->foreign('equipment_id')->references('id')->on('equipment')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('power_failures');
    }
};