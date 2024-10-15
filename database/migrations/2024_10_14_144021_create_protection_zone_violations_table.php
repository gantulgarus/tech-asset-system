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
        Schema::create('protection_zone_violations', function (Blueprint $table) {
            $table->id();

            // Foreign keys
            $table->unsignedBigInteger('branch_id');
            $table->unsignedBigInteger('province_id');
            $table->unsignedBigInteger('sum_id');
            $table->unsignedBigInteger('station_id');

            // Other fields
            $table->string('output_name');
            $table->string('customer_name');
            $table->string('address');
            $table->string('certificate_number');
            $table->string('action_taken');
            $table->timestamps();

            // Defining foreign key constraints
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->foreign('province_id')->references('id')->on('provinces')->onDelete('cascade');
            $table->foreign('sum_id')->references('id')->on('sums')->onDelete('cascade');
            $table->foreign('station_id')->references('id')->on('stations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('protection_zone_violations');
    }
};