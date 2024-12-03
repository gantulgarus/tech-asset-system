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
            $table->unsignedBigInteger('order_type_id')->nullable()->after('ude');
            $table->string('cause_cut')->nullable()->after('order_type_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('power_cuts', function (Blueprint $table) {
            $table->dropColumn(['order_type_id', 'cause_cut']);
        });
    }
};