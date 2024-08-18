<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rank extends Model
{
    use HasFactory;
    protected $table = 'rank';
    protected $primaryKey = "id";
    protected $fillable = ['rank','perkuliahan_id','rank_mhs', 'rank_upm', 'validasi'];

    public $timestamps = true;
   
    public function perkuliahan()
    {
        return $this->belongsTo(Perkuliahan::class, 'perkuliahan_id');
    }
}
