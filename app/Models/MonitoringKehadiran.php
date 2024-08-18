<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonitoringKehadiran extends Model
{
    use HasFactory;

    protected $table = 'monitoring_kehadiran';

    protected $fillable = [
        'perkuliahan_id',
        'kategori',
        'jumlah_pertemuan',
    ];

    public function perkuliahan()
    {
        return $this->belongsTo(Perkuliahan::class);
    }
}
