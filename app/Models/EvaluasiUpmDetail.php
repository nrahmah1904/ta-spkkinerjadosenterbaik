<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluasiUpmDetail extends Model
{
    use HasFactory;

    protected $table = 'evaluasiupm_detail';
    protected $primaryKey = 'id';
    protected $fillable = [
        'evaluasi_id',
        'jawaban',
        'kriteria_id',
        'kategori',
        'created_at'
    ];

    public $timestamps = false;

    public function evaluasi()
    {
        return $this->belongsTo(EvaluasiUpm::class, 'evaluasi_id');
    }

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class, 'kriteria_id');
    }
}
