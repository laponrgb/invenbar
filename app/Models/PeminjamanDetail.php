<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PeminjamanDetail extends Model
{
    protected $fillable = [
        'peminjaman_id',
        'barang_id',
        'jumlah',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
