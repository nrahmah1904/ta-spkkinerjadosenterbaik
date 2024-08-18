<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    use HasFactory;
    protected $table = 'kriteria';
    protected $primary = "idkriteria";
    protected $fillable = ['kode','kriteria','bobot','desimal','status','pengguna','updated_at', 'created_at'];

    public function nilai()
    {
        return $this->hasMany(Nilai::class, 'id_penilaian');
    }
}