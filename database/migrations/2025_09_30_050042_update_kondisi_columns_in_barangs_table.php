<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('barangs', function (Blueprint $table) {
            $table->dropColumn('kondisi'); // hapus enum lama

            $table->integer('jumlah_baik')->default(0);
            $table->integer('jumlah_rusak_ringan')->default(0);
            $table->integer('jumlah_rusak_berat')->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('barangs', function (Blueprint $table) {
            $table->enum('kondisi', ['Baik', 'Rusak Ringan', 'Rusak Berat'])->default('Baik');

            $table->dropColumn(['jumlah_baik', 'jumlah_rusak_ringan', 'jumlah_rusak_berat']);
        });
    }
};
