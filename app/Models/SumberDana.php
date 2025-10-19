<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SumberDana extends Model
{
    protected $table = 'sumberdanas'; 
    protected $fillable = ['nama_sumberdana'];

    public function barang(): HasMany
    {
        return $this->hasMany(Barang::class, 'sumberdana_id');
    }
}
