<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\Penyakit;
use App\Models\RawatJalan as ModelsRawatJalan;
use App\Models\User;
use App\Models\WebModel;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DetailPemetaanExport;
use App\Models\pasienPoli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RawatJalan;

class WebController extends Controller
{
    public function index()
    {
        $kecamatan = WebModel::where('district_id',3171040)->get();

        if(auth()->user()->level == 'super_admin'){
            $penyakit = Penyakit::all();
        } else {
            $penyakit = Penyakit::where('id_poli', auth()->user()->id_poli)->get();
        }

        $data =[
            'title'=>'pemetaan',
            // 'datapenyakit'=>$penyakit,
            'kecamatan'=>$kecamatan,
            'penyakit' => $penyakit
        ];
        return view('v_web',$data);
    }

    public function pemetaan($id)
    {
        $kecamatan = WebModel::where('id', $id)->first();

        //menggabungkan table rawat jalan - diagnosa - dan pasien dan mendapatkan data berdasarkan wilayah kelurahan
        $userRole = Auth::user()->level;
        if ($userRole != 'super_admin') {                            
            $data = pasienPoli::Join('rawatjalan', 'rawatjalan.id_pasien', '=', 'pasien_poli.id')
                            ->join('diagnosa','diagnosa.id','=','rawatjalan.id_diagnosa')
                            ->select('diagnosa.nama_diagnosa',DB::raw('count(*) as total')) 
                            ->join('pasien','pasien.id','=','pasien_poli.id_pasien')
                            ->groupBy('diagnosa.nama_diagnosa')
                            ->where('rawatjalan.status','rawat')
                            ->where('rawatjalan.poli',Auth()->user()->id_poli)
                            ->where('kelurahan',$id)
                            ->get();
        } else {
            $data = pasienPoli::Join('rawatjalan', 'rawatjalan.id_pasien', '=', 'pasien_poli.id')
                            ->join('diagnosa','diagnosa.id','=','rawatjalan.id_diagnosa')
                            ->select('diagnosa.nama_diagnosa',DB::raw('count(*) as total')) 
                            ->join('pasien','pasien.id','=','pasien_poli.id_pasien')
                            ->groupBy('diagnosa.nama_diagnosa')
                            ->where('rawatjalan.status','rawat')
                            ->where('kelurahan',$id)
                            ->get();
        }
        

        $penyakit = Penyakit::all();

        $data =[
            'title'=>'pemetaan',
            'datapemetaan'=>$data,
            'kecamatan' => $kecamatan,
        ];

        return view('v_web_detail',$data);
    }

    public function pemetaanPenyakit(Request $request)
    {
        if($request->input('penyakit') == 'default'){
            return redirect('/pemetaan');
        }
        
        // $selPenyakit = Penyakit::all();
        $penyakitId = $request->input('penyakit');

        // Mengambil data penyakit berdasarkan id yang dipilih
        $penyakitSel = Penyakit::find($penyakitId);
        // dd($penyakitSel);
        $kecamatan = WebModel::where('district_id',3171040)->get();

        if(auth()->user()->level == 'super_admin'){
            $penyakit = Penyakit::all();
        } else {
            $penyakit = Penyakit::where('id_poli', auth()->user()->id_poli)->get();
        }

        $data =[
            'title'=>'pemetaan',
            // 'datapenyakit'=>$penyakit,
            'kecamatan'=>$kecamatan,
            'penyakit' => $penyakit,
            'penyakitSel' => $penyakitSel
        ];

        return view('pemetaanPenyakit',$data);
    }

    public function pemetaanPenyakitDetail($id, $penyakitSel)
    {
        $kecamatan = WebModel::where('id', $id)->first();

        //menggabungkan table rawat jalan - diagnosa - dan pasien dan mendapatkan data berdasarkan wilayah kelurahan
        $userRole = Auth::user()->level;
        if ($userRole != 'super_admin') {
            $data = pasienPoli::Join('rawatjalan', 'rawatjalan.id_pasien', '=', 'pasien_poli.id')
                            ->join('diagnosa','diagnosa.id','=','rawatjalan.id_diagnosa')
                            ->select('diagnosa.nama_diagnosa',DB::raw('count(*) as total')) 
                            ->join('pasien','pasien.id','=','pasien_poli.id_pasien')
                            ->groupBy('diagnosa.nama_diagnosa')
                            ->where('rawatjalan.status','rawat')
                            ->where('diagnosa.nama_diagnosa', $penyakitSel)
                            ->where('rawatjalan.poli',Auth()->user()->id_poli)
                            ->where('kelurahan',$id)
                            ->get();
        } else {
            $data = pasienPoli::Join('rawatjalan', 'rawatjalan.id_pasien', '=', 'pasien_poli.id')
                            ->join('diagnosa','diagnosa.id','=','rawatjalan.id_diagnosa')
                            ->select('diagnosa.nama_diagnosa',DB::raw('count(*) as total')) 
                            ->join('pasien','pasien.id','=','pasien_poli.id_pasien')
                            ->groupBy('diagnosa.nama_diagnosa')
                            ->where('rawatjalan.status','rawat')
                            ->where('diagnosa.nama_diagnosa', $penyakitSel)
                            ->where('kelurahan',$id)
                            ->get();
        }

        $penyakit = Penyakit::all();

        $data =[
            'title'=>'pemetaan',
            'datapemetaan'=>$data,
            'kecamatan' => $kecamatan,
        ];
        return view('pemetaanPenyakitDetail',$data);
    }

    public function exportDataPemetaan($id)
    {
        $userRole = Auth::user()->level;
        $kecamatan = WebModel::where('id', $id)->first();
        if ($userRole != 'super_admin') {
            $query = pasienPoli::Join('rawatjalan', 'rawatjalan.id_pasien', '=', 'pasien_poli.id')
                                ->join('diagnosa','diagnosa.id','=','rawatjalan.id_diagnosa')
                                ->select('diagnosa.nama_diagnosa',DB::raw('count(*) as total')) 
                                ->join('pasien','pasien.id','=','pasien_poli.id_pasien')
                                ->groupBy('diagnosa.nama_diagnosa')
                                ->where('rawatjalan.status','rawat')
                                ->where('rawatjalan.poli',Auth()->user()->id_poli)
                                ->where('kelurahan',$id);
        } else {
            $query = pasienPoli::Join('rawatjalan', 'rawatjalan.id_pasien', '=', 'pasien_poli.id')
                                ->join('diagnosa','diagnosa.id','=','rawatjalan.id_diagnosa')
                                ->select('diagnosa.nama_diagnosa',DB::raw('count(*) as total')) 
                                ->join('pasien','pasien.id','=','pasien_poli.id_pasien')
                                ->groupBy('diagnosa.nama_diagnosa')
                                ->where('rawatjalan.status','rawat')
                                ->where('pasien.kelurahan',$id);
        }
        
        if ($userRole != 'super_admin') {
            $query->where('pasien_poli.id_poli', Auth()->user()->id_poli);
            $namapoli = Auth()->user()->poli->nama_poli;
        } else {
            $namapoli = 'Keseluruhan';
        }

        $namaKecamatan = $kecamatan->name;
                    
        $data = $query->get();

        // Menjalankan proses ekspor ke file Excel
        if ($userRole != 'super_admin') {
            return Excel::download(new DetailPemetaanExport($data, $namapoli, $namaKecamatan), 'Persebaran Penyakit Poli ' .$namapoli. ' di Kelurahan ' . $kecamatan->name . '.xlsx');
        }
            return Excel::download(new detailPemetaanExport($data, $namapoli, $namaKecamatan), 'Persebaran Penyakit Keseluruhan di Kelurahan ' . $kecamatan->name . '.xlsx');
    }
}
