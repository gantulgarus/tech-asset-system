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
            $table->string('created_user')->nullable()->after('responsible_officer');
            $table->string('controlled_user')->nullable()->after('created_user');
            $table->string('approved_user')->nullable()->after('controlled_user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('outage_schedules', function (Blueprint $table) {
            $table->dropColumn(['created_user', 'controlled_user', 'approved_user']);
        });
    }
};
