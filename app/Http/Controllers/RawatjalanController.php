<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\Penyakit;
use App\Models\Poli as ModelsPoli;
use App\Models\RawatJalan;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\detailHistoryExport;
use App\Models\pasienPoli;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Poli;

class RawatjalanController extends Controller
{
    public function index()
     {
        $events = array();

        if (auth()->user()->level != 'super_admin') {
            $aa = RawatJalan::select('tgl_control', RawatJalan::raw('COUNT(*) as total'))
            ->whereIn('id', function ($query) {
                $query->selectRaw('MAX(id)')
                ->from('rawatjalan')
                ->groupBy('id_pasien','id_diagnosa');
            })
            ->where('created_at', '>', Carbon::now()->subWeek())
            ->where('poli', auth()->user()->id_poli)
            ->where('status', 'rawat')
            ->groupBy('tgl_control')
            ->get();
        } else {
            // $aa = RawatJalan::selectraw('tgl_control as x, COUNT(*) as total')
            // $aa = RawatJalan::select('tgl_control', RawatJalan::raw('COUNT(*) as total'))
            // ->groupBy('tgl_control')
            // ->where('created_at', '>', Carbon::now()->subWeek())
            // ->where('status','rawat')
            // ->get();
            $aa = RawatJalan::select('tgl_control', RawatJalan::raw('COUNT(*) as total'))
            ->whereIn('id', function ($query) {
                $query->selectRaw('MAX(id)')
                ->from('rawatjalan')
                ->groupBy('id_pasien','id_diagnosa');
            })
            // ->where('created_at', '>', Carbon::now()->subWeek())
            ->where('status', 'rawat')
            ->groupBy('tgl_control')
            ->get();
            
        }

        // mendapatkan pasien berdasarkan dokter yang login / poli si dokter
        if(auth()->user()->level != 'super_admin'){
            $pasien  = pasienPoli::where('id_poli',auth()->user()->id_poli)->get();
        } else {
            $pasien = pasienPoli::all();
        }

        $poli = ModelsPoli::all();

        // mendapatkan penyakit berdasarkan dokter yang login / poli si dokter
        if(auth()->user()->level != 'super_admin'){
            $diagnosa  = Penyakit::where('id_poli',auth()->user()->id_poli)->get();
        } else {
            $diagnosa  = Penyakit::all();
        }

        foreach($aa as $booking){
            $color = null;
            if ($booking->title == 'Test') {
                $color = '#A6FF00';
            }
            if ($booking->title == 'Test 1') {
                $color = '#B073D8';
            }

            $events[]=[
                'title' => $booking->total,
                'start' => $booking->tgl_control,
                'end' => $booking->tgl_control,
                'color' => '#2FDA63',
                'textColor' => '#FFFFFF',
                'borderColor' => 'black'
            ];
            
        }

        return view('rawatjalan', ['events' => $events, 'poli'=>$poli, 'pasien'=>$pasien, 'diagnosa'=>$diagnosa]);
       
     }

     public function store(Request $request)
     { 
        
        // MENDAPATKAN TANGGAL SEKARANG
        $mytime = Carbon::now()->format('Y-m-d');

        if ($request->tgl_control < $mytime) {
            return back()->with('error','Tanggal Sudah Berlalu');
        } else {

            //MENDAPATKAN ID PETUGAS
            $petugas = auth()->user()->id;
            $poli = auth()->user()->id_poli;
                
            
            //MELAKUKAN INSERT KE DATABASE KE TABLE RAWAT JALAN
            if(auth()->user()->level == "super_admin"){
                RawatJalan::create([
                    'id_pasien' => $request->pasien,
                     'id_user'=> $petugas,
                    'id_diagnosa'=> $request->diagnosa,
                    'poli'=> $request->id_poli,
                    'tgl_periksa'=> $mytime,
                    'tgl_control'=> $request->tgl_control,
                    'status'=> 'rawat',
    
                ]);
            } else {
                RawatJalan::create([
                    'id_pasien' => $request->pasien,
                     'id_user'=> $petugas,
                    'id_diagnosa'=> $request->diagnosa,
                    'poli'=> $poli,
                    'tgl_periksa'=> $mytime,
                    'tgl_control'=> $request->tgl_control,
                    'status'=> 'rawat',
    
                ]);
            }
            
                return redirect('rawatjalan')->with('success','Data Berhasil Disimpan');
            
        }
     }

     public function history()
     {
        $userRole = Auth::user()->level;
        if ($userRole != 'super_admin') {
            $data = RawatJalan::select('id_pasien', 'id_diagnosa')
                    ->distinct()
                    ->groupBy('id_pasien', 'id_diagnosa')
                    ->where('poli', Auth()->user()->id_poli)
                    ->get();
        } else {
            $data = RawatJalan::select('id_pasien', 'id_diagnosa')
                        ->distinct()
                        ->groupBy('id_pasien', 'id_diagnosa')
                        ->get();
        }
        // $poli = ModelsPoli::all();

        return view('rawatjalanhistory', compact('data'));
     }

     public function detailHistory($id_pasien, $id_diagnosa){

        $detailData = RawatJalan::where('id_pasien', $id_pasien)
                                ->where('id_diagnosa', $id_diagnosa)
                                ->get();

        return view('rawatjalanhistorydetail', compact('detailData','id_pasien','id_diagnosa'));
     }

     public function exportDetail($id_pasien, $id_diagnosa)
        {
            $data = Rawatjalan::select('pasien.nama_pasien','diagnosa.nama_diagnosa','poli.nama_poli','rawatjalan.tgl_periksa','rawatjalan.tgl_control')
                                ->where('rawatjalan.id_pasien', $id_pasien)
                                ->where('rawatjalan.id_diagnosa', $id_diagnosa)
                                // ->where('rawatjalan.poli', Auth()->user()->id_poli)
                                ->join('poli','poli.id','=','rawatjalan.poli')
                                ->join('diagnosa','diagnosa.id','=','rawatjalan.id_diagnosa')
                                ->join('pasien_poli','pasien_poli.id','=','rawatjalan.id_pasien')
                                ->join('pasien','pasien.id','=','pasien_poli.id_pasien')
                                ->get();
            // dd($data);
            $nama_pasien = pasienPoli::select('pasien.nama_pasien')
                                    ->join('pasien', 'pasien.id', '=', 'pasien_poli.id_pasien')
                                    ->where('pasien_poli.id', $id_pasien)
                                    ->value('pasien.nama_pasien');

            // Menjalankan proses ekspor ke file Excel
            return Excel::download(new detailHistoryExport($data, $nama_pasien), 'History Rawat Jalan ' .$nama_pasien. '.xlsx');

            
        }

}