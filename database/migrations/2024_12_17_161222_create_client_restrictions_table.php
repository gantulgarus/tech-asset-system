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
        Schema::create('client_restrictions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->constrained('branches'); // Assuming 'branches' is your existing table for branches
            $table->foreignId('station_id')->constrained('stations'); // Assuming 'stations' is your existing table for stations
            $table->string('output_name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_restrictions');
    }
};