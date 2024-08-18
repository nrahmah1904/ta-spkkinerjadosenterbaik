<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perkuliahan extends Model
{
    use HasFactory;

    protected $table = 'perkuliahan';

    protected $fillable = [
        'kelas',
        'nidn',
        'tahun_ajaran_id',
        'kode'
    ];

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'nidn', 'nidn');
    }

    public function nilai()
    {
        return $this->hasMany(Nilai::class, 'perkuliahan_id');
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }

    public function matkul()
    {
        return $this->belongsTo(Matakuliah::class, 'kode', 'kode');
    }

    public function penilaian()
    {
        return $this->hasMany(Nilai::class, 'perkuliahan_id');
    }

    public function rank()
    {
        return $this->hasOne(Rank::class, 'perkuliahan_id');
    }

    public function monitoringKehadiran()
    {
        return $this->hasOne(MonitoringKehadiran::class, 'perkuliahan_id');
    }
}
