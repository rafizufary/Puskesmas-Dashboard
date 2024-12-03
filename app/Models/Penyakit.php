<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penyakit extends Model
{
    use HasFactory;
    protected $table = 'diagnosa';

    protected $fillable = [
       'id_poli', 'kode_diagnosa', 'nama_diagnosa'
    ];

    public function poli()
    {
        return $this->belongsTo(Poli::class,'id_poli');
    }
}
