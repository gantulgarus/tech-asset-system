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
        Schema::table('power_cuts', function (Blueprint $table) {
            // Drop the foreign key constraint
            $table->dropForeign('power_cuts_cause_cut_id_foreign');

            // Modify the cause_cut_id column to be nullable
            $table->integer('cause_cut_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('power_cuts', function (Blueprint $table) {
            // Drop the foreign key constraint
            $table->dropForeign('power_cuts_cause_cut_id_foreign');

            // Modify the cause_cut_id column to be non-nullable
            $table->integer('cause_cut_id')->nullable(false)->change();
        });
    }
};