<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Kandang;

class Pakan extends Model
{
    use HasFactory; 

    protected $fillable = [
        'total_pakan',
        'jumlah_jagung',
        'jumlah_multivitamin',
        'sisa_pakan',
        'tanggal'
    ];

    public function kandang(): HasMany
    {
        return $this->hasMany(Kandang::class);
    }
}
