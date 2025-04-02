<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;
use App\Models\Telur;

class Kandang extends Model
{
    protected $fillable = [
        'nama_kandang',
        'umur_ayam',
        'jumlah_ayam'
    ];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function telur(): HasMany
    {
        return $this->hasMany(Telur::class);
    }
}
