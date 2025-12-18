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
        Schema::table('purchase_orders', function (Blueprint $table) {
            $table->string('judul_po')->after('nomor_po')->nullable();
            $table->text('jenis_item')->change();
            $table->text('jenis_item_lainnya')->after('jenis_item')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchase_orders', function (Blueprint $table) {
            $table->dropColumn(['judul_po', 'jenis_item_lainnya']);
            $table->string('jenis_item')->change();
        });
    }
};
