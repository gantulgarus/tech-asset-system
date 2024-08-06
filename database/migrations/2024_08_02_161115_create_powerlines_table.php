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
        Schema::create('powerlines', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('station_id');
            $table->string('name');
            $table->unsignedBigInteger('volt_id');
            $table->date('create_year');
            $table->string('line_mark');
            $table->string('tower_mark');
            $table->integer('tower_count');
            $table->float('line_length');
            $table->string('isolation_mark');
            $table->timestamps();

            // Foreign keys
            $table->foreign('station_id')->references('id')->on('stations')->onDelete('cascade');
            $table->foreign('volt_id')->references('id')->on('volts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('powerlines');
    }
};