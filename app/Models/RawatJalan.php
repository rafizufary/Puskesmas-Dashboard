<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RawatJalan extends Model
{
    use HasFactory;
    protected $table = 'rawatjalan';

    protected $fillable = [
        'id_pasien', 'id_user','id_diagnosa','poli','tgl_periksa','tgl_control','status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'id_user');
    }

    public function pasien()
    {
        return $this->belongsTo(pasienPoli::class,'id_pasien');
    }

    public function diagnosa()
    {
        return $this->belongsTo(Penyakit::class,'id_diagnosa');
    }

    public function datapoli()
    {
        return $this->belongsTo(Poli::class,'poli');
    }

}
