<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('peminjamans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_peminjaman')->unique();
            $table->string('nama_peminjam');
            $table->string('telepon_peminjam');
            $table->string('email_peminjam')->nullable();
            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali')->nullable();
            $table->string('status')->default('Dipinjam'); // Dipinjam / Dikembalikan
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjamans');
    }
};
