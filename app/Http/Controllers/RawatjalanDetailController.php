<?php

namespace App\Http\Controllers;

use App\Models\pasienPoli as ModelsPasien;
use App\Models\Penyakit;
use App\Models\Poli;
use App\Models\RawatJalan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RawatjalanDetailController extends Controller
{
    public function index($id)
    {

        // mendapatkan data dari table rawat jalan berdasarkan tanggal control sama dengan tanggal yang kita pilih
        // $data = RawatJalan::where('tgl_control',$id)->get();

        if (auth()->user()->level == 'super_admin') {
            $data = ModelsPasien::select('pasien.nik_pasien', 'pasien.nama_pasien','diagnosa.nama_diagnosa','diagnosa.kode_diagnosa','rawatjalan.tgl_control','rawatjalan.tgl_periksa','rawatjalan.id')
                                ->join('pasien', 'pasien.id', '=', 'pasien_poli.id_pasien')
                                ->join('rawatjalan', 'rawatjalan.id_pasien', '=', 'pasien_poli.id')
                                ->join('diagnosa','diagnosa.id','=','rawatjalan.id_diagnosa')
                                ->where('rawatjalan.tgl_control',$id)
                                ->where('rawatjalan.status','rawat')
                                ->get();
        } else {
            $data = ModelsPasien::select('pasien.nik_pasien', 'pasien.nama_pasien','diagnosa.nama_diagnosa','diagnosa.kode_diagnosa','rawatjalan.tgl_control','rawatjalan.tgl_periksa','rawatjalan.id')
                                ->join('pasien', 'pasien.id', '=', 'pasien_poli.id_pasien')
                                ->join('rawatjalan', 'rawatjalan.id_pasien', '=', 'pasien_poli.id')
                                ->join('diagnosa','diagnosa.id','=','rawatjalan.id_diagnosa')
                                ->where('rawatjalan.poli',auth()->user()->id_poli)
                                ->where('rawatjalan.tgl_control',$id)
                                ->where('rawatjalan.status','rawat')
                                ->get();

        }

        // $rawatjalan = Rawatjalan::select('id_diagnosa');

        
        $pasien  = ModelsPasien::where('id_poli',auth()->user()->id_poli)->get();
        $poli = Poli::all();
        
        $diagnosa  = Penyakit::where('id_poli',auth()->user()->id_poli)->get();

        return view('rawatjalandetail', ['detail' => $data, 'pasien'=>$pasien,'poli'=>$poli,'diagnosa'=>$diagnosa]);

    }

    public function update(Request $request, $id)
    {
        $Data = RawatJalan::find($id);

        $Data->update([
            'status' => 'selesai',
        ]);

        $newData = new RawatJalan();

        $tglPeriksa = Carbon::now()->format('Y-m-d');

        if ($request->tgl_control < $tglPeriksa) {
            $Data->update([
                'status' => 'rawat',
            ]);
            return back()->with('error','Tanggal Sudah Berlalu');
        } else {
            if(auth()->user()->level != 'super_admin'){

                $newData->id_pasien = $Data->id_pasien;
                $newData->id_user = auth()->user()->id;
                $newData->poli = auth()->user()->id_poli;
                $newData->id_diagnosa = $request->diagnosa;
                $newData->tgl_periksa = $tglPeriksa;
                $newData->tgl_control = $request->tgl_control;
                $newData->status = 'rawat';
                $newData->save();
            } else {
                $newData->id_pasien = $Data->id_pasien;
                $newData->id_user = $Data->id_user;
                $newData->poli = $Data->poli;
                $newData->id_diagnosa = $Data->id_diagnosa;
                $newData->tgl_periksa = $tglPeriksa;
                $newData->tgl_control = $request->tgl_control;
                $newData->status = 'rawat';
                $newData->save();
            }

        return redirect('/rawatjalan')->with('success','Data Pasien Berhasil Diupdate');
        }
    }

    public function destroy($id)
    {
        $data = RawatJalan::find($id);
        if (! $data) {
            return response()->json([
                'error' => 'Unable to locate the event'
            ], 404);
        }

        $data->update([
            'status' => 'selesai',
        ]);

        return redirect()->back()->with('success','Pasien Telah Selesai Rawat Jalan');
    }

    public function selesai($id)
    {
        $data = RawatJalan::find($id);
        $data->update([
            'status' => 'selesai',
        ]);
        // dd($data);

        return redirect()->back()->with('success', 'Pasien Telah Selesai Rawat Jalan');
    }
}
