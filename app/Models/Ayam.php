<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ayam extends Model
{
    protected $fillable = [
        'kandang_id',
        'jumlah_ayam_mati',
        'jumlah_pakan',
        'tanggal',
    ];

    public function kandang()
    {
        return $this->belongsTo(Kandang::class);
    }
}
