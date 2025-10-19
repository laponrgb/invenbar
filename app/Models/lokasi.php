<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class lokasi extends Model
{
    protected $fillable = ['nama_lokasi'];

    public function barang(): HasMany
    {
        return $this->hasMany(Barang::class, 'lokasi_id');
    }
}
