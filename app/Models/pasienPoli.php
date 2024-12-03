<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pasienPoli extends Model
{
    use HasFactory;
    protected $table = 'pasien_poli';

    protected $fillable = [
        'id_pasien', 'id_poli'
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class,'id_pasien');
    }

    public function datapoli()
    {
        return $this->belongsTo(Poli::class,'id_poli');
    }
}
