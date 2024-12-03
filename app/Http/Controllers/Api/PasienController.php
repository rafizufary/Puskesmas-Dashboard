<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\pasienPoli;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\PasienResource;
use GuzzleHttp\Promise\Create;
use App\Models\Poli;

use Illuminate\Support\Facades\Validator;
use App\Models\Pasien;
use App\Models\Verifikasi;

class PasienController extends Controller
{
    //
    public function index()
    {
        $pasien = Verifikasi::all();
        // $pasien = pasienPoli::count();

        // return new PasienResource(true, "Data Pasien", $pasien);
        return response()->json([
            'status' => true,
            'message' => 'Data ditemukan',
            'data' => $pasien,
        ],200);
    }

    public function show($id)
    {
        $pasien = Verifikasi::find($id);
        // $pasien = pasienPoli::find($id);

        // return new PasienResource(true,'Detail Pasien', $pasien);
        if($pasien){
            return response()->json([
                'status' => true,
                'message' => 'Data ditemukan',
                'data' => $pasien,
            ],200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
            ]); 
        }
    }

    public function store(Request $request)
    {
        // menyimpan data
        $dataPoli = new Verifikasi();

        $rules = [
            'nik_pasien' => 'required',
            'nama_pasien' => 'required',
            'jenis_kelamin' => 'required',
            'tgl_lahir' => 'required',
            'alamat' => 'required',
            'rt' => 'required',
            'rw' => 'required',
            'provinsi' => 'required',
            'kota' => 'required',
            'kecamatan' => 'required',
            'kelurahan' => 'required',
            'notelepon' => 'required',
            'no_bpjs' => 'required',
        ];
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => 'Gagal memasukan data',
                'data' => $validator->errors()
            ]);
        }

        $dataPoli->nik_pasien = $request->nik_pasien;
        $dataPoli->nama_pasien = $request->nama_pasien;
        $dataPoli->jenis_kelamin = $request->jenis_kelamin;
        $dataPoli->tgl_lahir = $request->tgl_lahir;
        $dataPoli->alamat = $request->alamat;
        $dataPoli->rt = $request->rt;
        $dataPoli->rw = $request->rw;
        $dataPoli->provinsi = $request->provinsi;
        $dataPoli->kota = $request->kota;
        $dataPoli->kecamatan = $request->kecamatan;
        $dataPoli->kelurahan = $request->kelurahan;
        $dataPoli->notelepon = $request->notelepon;
        $dataPoli->no_bpjs = $request->no_bpjs;

        $post = $dataPoli->save();

        return response()->json([
            'status' => true,
            'message' => 'Sukses memasukan data'
        ]);
        $pasien = Verifikasi::create([
            $request->all()
        ]);

        return new PasienResource(true,'Simpan Data Pasien Berhasil', $pasien);
    }

    public function destroy($id)
    {
        $pasien = Verifikasi::findOrFail($id);
        // $pasien->delete();
        if(empty($pasien)){
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
            ],404);
        }

        $pasien = $pasien->delete();

        return response()->json([
            'status' => true,
            'message' => 'Sukses melakukan delete data'
        ]);
        
        // return new PasienResource(true,'Hapus Data Pasien Berhasil', $pasien);
    }

}
