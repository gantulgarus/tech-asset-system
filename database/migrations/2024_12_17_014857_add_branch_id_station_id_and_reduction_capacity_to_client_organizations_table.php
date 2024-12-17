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
        Schema::table('client_organizations', function (Blueprint $table) {
            $table->unsignedBigInteger('branch_id')->nullable()->after('id');
            $table->unsignedBigInteger('station_id')->nullable()->after('branch_id');
            $table->float('reduction_capacity')->nullable()->after('station_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('client_organizations', function (Blueprint $table) {
            $table->dropColumn(['branch_id', 'station_id', 'reduction_capacity']);
        });
    }
};