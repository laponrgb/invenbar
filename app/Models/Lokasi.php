<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lokasi extends Model
{
    protected $table = 'lokasis';

    protected $fillable = [
        'nama_lokasi',
        'ketua_id',
    ];

    public function barang(): HasMany
    {
        return $this->hasMany(Barang::class, 'lokasi_id');
    }

    public function ketua(): BelongsTo
    {
        return $this->belongsTo(User::class, 'ketua_id');
    }
}
