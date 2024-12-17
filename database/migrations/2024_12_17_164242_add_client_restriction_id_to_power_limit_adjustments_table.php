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
        Schema::table('power_limit_adjustments', function (Blueprint $table) {
            $table->unsignedBigInteger('client_restriction_id')->nullable(); // Adding the new column
            $table->foreign('client_restriction_id')->references('id')->on('client_restrictions')->onDelete('set null'); // Add foreign key constraint if needed
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('power_limit_adjustments', function (Blueprint $table) {
            //
        });
    }
};