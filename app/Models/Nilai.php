<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    use HasFactory;
    protected $table = 'penilaian';
    protected $primary = "id";
    protected $fillable = ['id','tanggal_penilaian','nim','nidn', 'tahun_ajaran', 'tahun_ajaran_id', 'perkuliahan_id'];


    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'nidn', 'nidn');
    }

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim');
    }

    public function evaluasimhs()
    {
        return $this->hasMany(Evaluasimhs::class, 'id_penilaian');
    }
    
    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'tahun_ajaran_id');
    }
    public function perkuliahan()
    {
        return $this->belongsTo(Perkuliahan::class, 'perkuliahan_id');
    }
}