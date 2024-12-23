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
        Schema::table('outage_schedules', function (Blueprint $table) {
            $table->foreignId('outage_schedule_type_id')
                ->nullable()
                ->constrained('outage_schedule_types')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('outage_schedules', function (Blueprint $table) {
            $table->dropForeign(['outage_schedule_type_id']);
            $table->dropColumn('outage_schedule_type_id');
        });
    }
};