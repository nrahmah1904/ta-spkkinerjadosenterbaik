<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluasiupm extends Model
{
    use HasFactory;
    protected $table = 'evaluasiupm';
    protected $primary = "id";
    protected $fillable = ['id', 'tanggal_penilaian', 'perkuliahan_id', 'tahun_ajaran_id'];

    public $timestamps = true;

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'tahun_ajaran_id');
    }
    public function perkuliahan()
    {
        return $this->belongsTo(Perkuliahan::class, 'perkuliahan_id');
    }
    public function evaluasiUpmDetails()
    {
        return $this->hasMany(EvaluasiUpmDetail::class, 'evaluasi_id');
    }
}
