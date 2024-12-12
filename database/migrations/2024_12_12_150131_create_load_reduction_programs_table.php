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
        Schema::create('load_reduction_programs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('branch_id');
            $table->unsignedBigInteger('station_id');
            $table->string('company_name');
            $table->string('output_name');
            $table->float('reduction_capacity');
            $table->float('pre_reduction_capacity');
            $table->integer('reduction_duration');
            $table->float('reduced_capacity');
            $table->float('post_reduction_capacity');
            $table->time('restoration_time');
            $table->float('energy_not_supplied');
            $table->text('remarks')->nullable();
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
        Schema::dropIfExists('load_reduction_programs');
    }
};