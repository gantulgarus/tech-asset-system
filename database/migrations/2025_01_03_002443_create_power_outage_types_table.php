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
        Schema::create('power_outage_types', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->string('name')->unique(); // Name of the outage type
            $table->text('description')->nullable(); // Description of the type
            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('power_outage_types');
    }
};
