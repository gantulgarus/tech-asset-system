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
        Schema::table('power_outages', function (Blueprint $table) {
            $table->string('act_file_path')->nullable()->after('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('power_outages', function (Blueprint $table) {
            $table->dropColumn('act_file_path');
        });
    }
};