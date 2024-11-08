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
            $table->enum('technological_violation', ['Аваар', '1-р зэргийн саатал', '2-р зэргийн саатал'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('power_outages', function (Blueprint $table) {
            $table->dropColumn('technological_violation');
        });
    }
};
