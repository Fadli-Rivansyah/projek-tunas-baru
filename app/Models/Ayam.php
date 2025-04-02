<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ayam extends Model
{
    protected $fillable = [
        'jumlah_ayam_hidup',
        'jumlah_ayam_mati',
        'pakan',
        'tanggal',
    ];
}
