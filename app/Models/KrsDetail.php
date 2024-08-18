<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KrsDetail extends Model
{
    use HasFactory;

    protected $table = 'krs_details';

    protected $fillable = [
        'krs_id',
        'perkuliahan_id'
    ];

    public function krs()
    {
        return $this->belongsTo(Krs::class);
    }

    public function perkuliahan()
    {
        return $this->belongsTo(Perkuliahan::class);
    }
}
