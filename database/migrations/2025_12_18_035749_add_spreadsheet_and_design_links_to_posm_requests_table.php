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
        Schema::table('posm_requests', function (Blueprint $table) {
            $table->string('spreadsheet_link')->nullable()->after('additional_link');
            $table->string('design_link')->nullable()->after('spreadsheet_link');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posm_requests', function (Blueprint $table) {
            $table->dropColumn(['spreadsheet_link', 'design_link']);
        });
    }
};
