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
        Schema::create('power_cut_types', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('name')->unique(); // Name of the power cut type
            $table->text('description')->nullable(); // Optional description
            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('power_cut_types');
    }
};
