<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Kandang;
use App\Models\User;

class Ayam extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'kandang_id',
        'total_ayam',
        'jumlah_ayam_mati',
        'jumlah_pakan',
        'tanggal',
    ];

    public function kandang()
    {
        return $this->belongsTo(Kandang::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
