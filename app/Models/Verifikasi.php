<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Verifikasi extends Model
{
    use HasFactory;

    protected $table = 'verifikasi';

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

}
