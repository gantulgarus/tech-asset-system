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
        Schema::table('load_reduction_programs', function (Blueprint $table) {
            $table->renameColumn('reduction_duration', 'reduction_time');
            $table->time('reduction_time')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('load_reduction_programs', function (Blueprint $table) {
            $table->renameColumn('reduction_time', 'reduction_duration');
            $table->string('reduction_duration')->change();
        });
    }
};