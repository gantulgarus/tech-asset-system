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
        Schema::create('journal_status_changes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('status_id')->constrained('order_statuses')->onDelete('cascade');
            $table->foreignId('order_journal_id')->constrained('order_journals')->onDelete('cascade');
            $table->text('comment');
            $table->foreignId('changed_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('journal_status_changes');
    }
};