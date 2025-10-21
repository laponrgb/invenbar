<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataSiswa extends Model
{
    protected $fillable = [
        'nis',
        'nama_siswa',
        'kelas',
        'jenis_kelamin',
        'email',
        'alamat'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
