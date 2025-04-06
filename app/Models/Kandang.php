<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;
use App\Models\Ayam;
use App\Models\Telur;

class Kandang extends Model
{
    protected $fillable = [
        'nama_karyawan',
        'nama_kandang',
        'umur_ayam',
        'jumlah_ayam',
        'user_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function telur(): HasMany
    {
        return $this->hasMany(Telur::class);
    }

    public function ayams(): HasMany
    {
        return $this->hasMany(Ayam::class);
    }
}
