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
        Schema::create('powerline_geojsons', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('powerline_id'); // Foreign key reference to powerline table
            $table->string('filename'); // Name of the uploaded file
            $table->string('path'); // Path to the uploaded file
            $table->timestamps();

            // Add foreign key constraint if you have a powerline table
            $table->foreign('powerline_id')->references('id')->on('powerlines')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('powerline_geojsons');
    }
};