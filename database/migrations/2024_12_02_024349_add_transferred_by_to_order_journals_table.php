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
        Schema::table('order_journals', function (Blueprint $table) {
            $table->string('transferred_by')->nullable()->after('end_date'); // 'content'-ийн дараа нэмнэ
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_journals', function (Blueprint $table) {
            $table->dropColumn('transferred_by');
        });
    }
};