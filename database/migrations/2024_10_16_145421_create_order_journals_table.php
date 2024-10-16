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
        Schema::create('order_journals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('branch_id');
            $table->unsignedBigInteger('order_type_id');
            $table->string('order_number');
            $table->timestamp('received_at')->nullable();
            $table->unsignedBigInteger('station_id')->nullable();
            $table->unsignedBigInteger('equipment_id')->nullable();
            $table->text('content')->nullable();
            $table->datetime('start_date');
            $table->datetime('end_date');
            $table->unsignedBigInteger('created_user_id');
            $table->unsignedBigInteger('received_user_id')->nullable();
            $table->unsignedBigInteger('approved_user_id')->nullable();
            $table->unsignedBigInteger('order_status_id');
            $table->datetime('real_start_date')->nullable();
            $table->datetime('real_end_date')->nullable();
            $table->timestamps();

            // Foreign key constraints (optional, add as needed)
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->foreign('order_type_id')->references('id')->on('order_types')->onDelete('cascade');
            $table->foreign('station_id')->references('id')->on('stations')->onDelete('cascade');
            $table->foreign('equipment_id')->references('id')->on('equipment')->onDelete('cascade');
            $table->foreign('order_status_id')->references('id')->on('order_statuses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_journals');
    }
};
