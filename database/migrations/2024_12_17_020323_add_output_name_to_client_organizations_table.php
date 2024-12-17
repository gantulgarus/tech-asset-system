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
            $table->string('output_name')->nullable()->after('reduction_capacity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('client_organizations', function (Blueprint $table) {
            $table->dropColumn('output_name');
        });
    }
};