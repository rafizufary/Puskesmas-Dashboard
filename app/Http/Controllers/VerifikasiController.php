<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\pasienPoli;
use App\Models\Verifikasi;
use App\Models\Poli;
use Illuminate\Http\Request;

class VerifikasiController extends Controller
{
    public function index()
    {
        $data = Verifikasi::all();
        $poli = Poli::all();

        return view('verifikasi', compact('data','poli'));
    }

    public function store(Request $request, $id)
    {
        $dataPasien = Verifikasi::find($id);
        $poli = $request->id_poli;

        $nikPasien = $dataPasien->nik_pasien;
        $sudahAda = Pasien::where('nik_pasien', $nikPasien)->first();
        if($sudahAda){
            return back()->with('error', 'Pasien sudah terdaftar.');
        }
        

        if(substr($dataPasien->notelepon,0,1) == '0') {
            $nohp = substr($dataPasien->notelepon,1);
        }
        if($dataPasien){
                $pasien = Pasien::create([
                    'nik_pasien'=> $dataPasien->nik_pasien,
                    'nama_pasien'=> $dataPasien->nama_pasien,
                    'jenis_kelamin'=> $dataPasien->jenis_kelamin,
                    'tgl_lahir' => $dataPasien->tgl_lahir,
                    'alamat' => $dataPasien->alamat,
                    'rt' => $dataPasien->rt,
                    'rw' => $dataPasien->rw,
                    'provinsi' => $dataPasien->provinsi,
                    'kota' => $dataPasien->kota,
                    'kecamatan' => $dataPasien->kecamatan,
                    'kelurahan' => $dataPasien->kelurahan,
                    'notelepon' => '+62'.$nohp,
                    'no_bpjs'=> $dataPasien->no_bpjs
                ]);

                if(auth()->user()->level == "super_admin"){
                    pasienPoli::create([
                        'id_pasien' => $pasien->id,
                        'id_poli' => $poli
                    ]);
                } else {
                    pasienPoli::create([
                        'id_pasien' => $pasien->id,
                        'id_poli' => auth()->user()->id_poli
                    ]);
                }
    
                if($pasien){
                    $dataPasien->delete();
                }
        }

        return redirect()->back()->with('success','Verifikasi Berhasil');
    }

    public function destroy($id)
    {
      	$pasien = Verifikasi::find($id);
      	$pasien->delete();
      
     	return redirect()->back()->with('success','Berhasil Menghapus Pasien'); 
    }
}
