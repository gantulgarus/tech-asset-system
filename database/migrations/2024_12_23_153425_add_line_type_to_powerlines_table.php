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
        Schema::table('powerlines', function (Blueprint $table) {
            $table->enum('line_type', ['ЦДАШ', 'ЦДКШ'])->default('ЦДАШ');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('powerlines', function (Blueprint $table) {
            $table->dropColumn('line_type');
        });
    }
};