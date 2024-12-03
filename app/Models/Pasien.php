<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    use HasFactory;

    protected $table = 'pasien';

    protected $fillable = [
        'nik_pasien',
        'nama_pasien',
        'jenis_kelamin',
        'tgl_lahir',
        'alamat',
        'rt',
        'rw',
        'provinsi',
        'kota',
        'kecamatan',
        'kelurahan',
        'notelepon',
        'no_bpjs',
    ];

    public function village()
    {
        return $this->belongsTo(Village::class,'kelurahan');
    }

    public function district()
    {
        return $this->belongsTo(District::class,'kecamatan');
    }

    public function regencies()
    {
        return $this->belongsTo(Regency::class,'kota');
    }

    public function provinces()
    {
        return $this->belongsTo(Province::class,'provinsi');
    }

    public function datapoli()
    {
        return $this->belongsTo(Poli::class,'poli');
    }


}
