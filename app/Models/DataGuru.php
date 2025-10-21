<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataGuru extends Model
{
    protected $fillable = [
        'nip',
        'nama_guru',
        'email',
        'alamat'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
