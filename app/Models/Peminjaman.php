<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{

    protected $table = 'peminjamans';

    protected $fillable = [
        'nama_peminjam',
        'telepon_peminjam',
        'email_peminjam',
        'tanggal_pinjam',
        'tanggal_kembali',
        'status',
    ];

    public function details()
    {
        return $this->hasMany(PeminjamanDetail::class);
    }
}
