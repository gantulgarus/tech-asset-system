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
            // Change the reduction_time column type from time to timestamp
            $table->timestamp('reduction_time')->nullable()->change();

            // Add a new column client_organization_id
            $table->unsignedBigInteger('client_organization_id')->nullable()->after('reduction_time');

            // Add a foreign key constraint
            $table->foreign('client_organization_id')->references('id')->on('client_organizations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('load_reduction_programs', function (Blueprint $table) {
            // Revert the reduction_time column back to time
            $table->time('reduction_time')->nullable()->change();

            // Drop the client_organization_id column
            $table->dropForeign(['client_organization_id']);
            $table->dropColumn('client_organization_id');
        });
    }
};