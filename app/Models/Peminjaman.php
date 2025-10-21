<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjamans';

    protected $fillable = [
        'kode_peminjaman',
        'nama_peminjam',
        'telepon_peminjam',
        'email_peminjam',
        'foto_peminjam',
        'dusun',
        'desa',
        'rt',
        'rw',
        'kecamatan',
        'kabupaten',
        'provinsi',
        'kode_pos',
        'catatan_alamat',
        'tanggal_pinjam',
        'tanggal_kembali',
        'status',
    ];


    public function details()
    {
        return $this->hasMany(PeminjamanDetail::class);
    }
}
