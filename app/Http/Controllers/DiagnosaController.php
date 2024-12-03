<?php

namespace App\Http\Controllers;

use App\Models\Penyakit;
use App\Models\Poli;
use Diagnosa;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DiagnosaExport;
use App\Models\WebModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiagnosaController extends Controller
{
    public function index()
     {
        
        if (auth()->user()->level == 'super_admin') {
            $diagnosa = Penyakit::all();
        }else{
            $diagnosa  = Penyakit::where('id_poli',auth()->user()->id_poli)->get();

        }

         $poli = Poli::all();


         return view('diagnosa',compact('diagnosa','poli'));
     }

     public function exportDiagnosa()
     {
        $userRole = Auth::user()->level;
        
        $query = Penyakit::select('poli.nama_poli', 'diagnosa.kode_diagnosa', 'diagnosa.nama_diagnosa')->join('poli', 'diagnosa.id_poli', '=', 'poli.id');
                        
        if ($userRole != 'super_admin') {
            $query->where('diagnosa.id_poli', Auth()->user()->id_poli);
            $namapoli = Auth()->user()->poli->nama_poli;
        } else {
            $namapoli = "keseluruhan";
        }

        $data = $query->get();

        if($userRole != 'super_admin'){
            return Excel::download(new DiagnosaExport($data, $namapoli), 'Data Penyakit Poli ' .$namapoli. '.xlsx');
        }
        return Excel::download(new DiagnosaExport($data, $namapoli), 'Data Penyakit Keseluruhan.xlsx');
     }

     public function store(Request $request)
     {

       $chekkode =  Penyakit::where('kode_diagnosa',$request->kode_diagnosa)->first();
       if ($chekkode != null) {
        return back()->with('error','Kode Diagnosa Sudah Ada');
        } else {
            if(auth()->user()->level == "super_admin"){
                Penyakit::create([
                    'id_poli' => $request->id_poli,
                    'kode_diagnosa' => $request->kode_diagnosa,
                    'nama_diagnosa'=> $request->nama_diagnosa
        
                ]);
            } else {
                Penyakit::create([
                    'id_poli' => auth()->user()->id_poli,
                    'kode_diagnosa' => $request->kode_diagnosa,
                    'nama_diagnosa'=> $request->nama_diagnosa
        
                ]);
            }
            
    
            return redirect('/diagnosa')->with('success','Data Berhasil Disimpan');
        }

     }

      public function update(Request $request, $id)
      {
          $user = Penyakit::find($id);
        
        //   $checkkode = Penyakit::where('kode_diagnosa', $request->kode_diagnosa)->first();
        //   if($checkkode){
        //     return back()->with('error', 'Kode Diagnosa Sudah Ada.');
        //   }

          if(auth()->user()->level == "super_admin"){
            $user->id_poli = $request->id_poli;
          }
          $user->kode_diagnosa = $request->kode_diagnosa;
          $user->nama_diagnosa = $request->nama_diagnosa;
  
          $user->update();
          return redirect('/diagnosa')->with('success','Data Berhasil Diupdate');
  
  
      }

        //fungsi untuk melakukan hapus kategori berdasarkan id
    public function destroy($id)
    {
        $diagnosa = Penyakit::find($id);
        try {
            
            // Hapus data diagnosa
            $diagnosa->delete();
    
            return redirect('/diagnosa')->with('success', 'Data Pasien Berhasil Dihapus');
        } catch (\Exception $e) {
            return redirect('/diagnosa')->with('error', 'Data Diagnosa tidak dapat dihapus karena masih terhubung dengan rawat jalan.');
        }
    }
}
