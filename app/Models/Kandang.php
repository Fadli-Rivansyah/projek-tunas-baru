<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\Ayam;
use App\Models\Telur;
use App\Models\Pakan;

class Kandang extends Model
{
    use HasFactory;
    
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

    public function telur(): HasOne
    {
        return $this->hasOne(Telur::class);
    }

    public function ayam(): HasOne
    {
        return $this->hasOne(Ayam::class);
    }

    public function pakan(): BelongsTo
    {
        return $this->belongsTo(Pakan::class);
    }
}
