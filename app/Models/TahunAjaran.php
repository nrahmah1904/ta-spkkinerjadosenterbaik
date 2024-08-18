<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunAjaran extends Model
{
    use HasFactory; 
    protected $table = 'tahunajarans';
    protected $fillable = ['tahun_ajaran', 'is_active', 'ganjil_genap'];

    protected $casts = [
        'is_active' => 'string',
    ];

    public static function getActiveTahunAjaran()
    {
        return self::where('is_active', 'Aktif')->first();
    }
}
