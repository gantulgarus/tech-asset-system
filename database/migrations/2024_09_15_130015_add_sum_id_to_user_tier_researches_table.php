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
        Schema::table('user_tier_research', function (Blueprint $table) {
            // Assuming sum_id refers to the id in the sums table
            $table->unsignedBigInteger('sum_id')->nullable()->after('province_id');

            // Foreign key constraint (if you're using foreign keys)
            $table->foreign('sum_id')->references('id')->on('sums')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_tier_research', function (Blueprint $table) {
            $table->dropForeign(['sum_id']);
            $table->dropColumn('sum_id');
        });
    }
};