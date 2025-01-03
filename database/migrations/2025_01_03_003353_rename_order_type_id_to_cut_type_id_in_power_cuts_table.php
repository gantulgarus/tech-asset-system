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
            $table->renameColumn('order_type_id', 'cut_type_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('power_cuts', function (Blueprint $table) {
            $table->renameColumn('cut_type_id', 'order_type_id');
        });
    }
};
