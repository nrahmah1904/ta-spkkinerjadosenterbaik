<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skalanilai extends Model
{
    use HasFactory;
    protected $table = 'skalanilai';
    protected $primaryKey = 'id';
    protected $fillable = ['id','idkriteria','skalanilai','nilai'];

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class);
    }
}