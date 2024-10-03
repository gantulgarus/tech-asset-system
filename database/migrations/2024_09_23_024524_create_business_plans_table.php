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
        Schema::create('business_plans', function (Blueprint $table) {
            $table->id();
            $table->enum('plan_type', ['Их засвар', 'ТЗБАХ', 'Хөрөнгө оруулалт']);
            $table->unsignedBigInteger('branch_id');
            $table->string('infrastructure_name');
            $table->string('task_name');
            $table->string('unit');
            $table->float('quantity');
            $table->float('budget_without_vat');
            $table->float('performance_amount');
            $table->float('variance_amount');
            $table->string('desc')->nullable();
            $table->float('performance_percentage');
            $table->timestamps();

            // Add foreign key constraint if necessary
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_plans');
    }
};