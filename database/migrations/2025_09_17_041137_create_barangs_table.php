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
        Schema::create('barangs', function (Blueprint $table) {
        $table->id();
        $table->string('kode_barang', 50)->unique();
        $table->string('nama_barang', 150);

        $table->foreignId('kategori_id')
            ->constrained('kategoris')
            ->onUpdate('cascade')
            ->onDelete('restrict');

        $table->foreignId('lokasi_id')
            ->constrained('lokasis')
            ->onUpdate('cascade')
            ->onDelete('restrict');

        $table->foreignId('sumberdana_id')
            ->constrained('sumberdanas')
            ->onUpdate('cascade')
            ->onDelete('restrict');

        $table->integer('jumlah')->default(0);
        $table->string('satuan', 20);
        $table->enum('kondisi', ['Baik', 'Rusak Ringan', 'Rusak Berat'])->default('Baik');
        $table->date('tanggal_pengadaan');
        $table->string('gambar')->nullable();
        $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
