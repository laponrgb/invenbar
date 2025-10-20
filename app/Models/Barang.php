<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Barang extends Model
{
    // Kolom yang bisa diisi mass-assignment
    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'kategori_id',
        'lokasi_id',
        'sumberdana_id', // ✅ tambahkan ini
        'satuan',
        'jumlah',
        'jumlah_baik',
        'jumlah_rusak_ringan',
        'jumlah_rusak_berat',
        'tanggal_pengadaan',
        'gambar',
    ];

    protected $casts = [
        'tanggal_pengadaan' => 'date',
    ];

    /**
     * Relasi ke Kategori
     */
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    /**
     * Relasi ke Lokasi
     */
    public function lokasi(): BelongsTo
    {
        return $this->belongsTo(Lokasi::class, 'lokasi_id');
    }

    /**
     * Relasi ke Sumber Dana
     */
    public function sumberdana(): BelongsTo
    {
        return $this->belongsTo(SumberDana::class, 'sumberdana_id');
    }

    /**
     * Accessor: hitung jumlah otomatis
     */
    public function getJumlahAttribute(): int
    {
        return ($this->attributes['jumlah_baik'] ?? 0)
             + ($this->attributes['jumlah_rusak_ringan'] ?? 0)
             + ($this->attributes['jumlah_rusak_berat'] ?? 0);
    }

    /**
     * Accessor: ringkasan kondisi barang
     */
    public function getKondisiSummaryAttribute(): array
    {
        return [
            'baik'          => $this->jumlah_baik,
            'rusak_ringan'  => $this->jumlah_rusak_ringan,
            'rusak_berat'   => $this->jumlah_rusak_berat,
        ];
    }
}
