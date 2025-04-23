<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Kandang;
use App\Models\User;
use App\Models\Ayam;

class Telur extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'kandang_id',
        'jumlah_telur_bagus',
        'jumlah_telur_retak',
        'tanggal'
    ];

    public function kandang()
    {
        return $this->belongsTo(Kandang::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ayam()
    {
        return $this->belongsTo(Ayam::class);
    }

    //search -> laravel scout
   
}
