<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluasimhs extends Model
{
    use HasFactory;
    protected $table = 'evaluasimhs';
    protected $primary = "id_evaluasimhs";
    public $incrementing = false;
    protected $fillable = ['jawaban','id_penilaian','id_kriteria'];

    public $timestamps = false;

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }
    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class, 'id_kriteria');
    }
    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }

}