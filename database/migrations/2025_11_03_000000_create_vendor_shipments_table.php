<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('vendor_shipments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('resi_pengiriman')->unique();
            $table->string('nama_vendor');
            $table->string('kontak_vendor');
            $table->string('jenis_item');
            $table->string('jumlah_item');
            $table->text('alamat_pengiriman');
            $table->date('tanggal_pengiriman');
            $table->text('catatan')->nullable();
            $table->string('status');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vendor_shipments');
    }
};