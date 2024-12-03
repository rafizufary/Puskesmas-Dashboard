<?php

namespace App\Http\Controllers;

use App\Models\Poli;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PoliExport;
use Illuminate\Http\Request;

class PoliController extends Controller
{

    public function exportPoli()
    {
        return Excel::download(new PoliExport, 'Data Poli.xlsx');
    }

    public function index()
     {
         $poli  = Poli::all();

       
         return view('poli',compact('poli'));
     }

     public function store(Request $request)
     {
        $sudahAda = Poli::where('kode_poli', $request->kode_poli)->first();

        if($sudahAda){
            return back()->with('error', 'Kode Poli Sudah Terdaftar.');
        }

         Poli::create([
             'kode_poli' => $request->kode_poli,
             'nama_poli'=> $request->nama_poli
 
         ]);
 
         return redirect('/poli')->with('success','Data Berhasil Disimpan');
     }

     public function update(Request $request, $id)
     {
         $user = Poli::find($id);
 
         $user->kode_poli = $request->kode_poli;
         $user->nama_poli = $request->nama_poli;
 
         $user->save();
         return redirect('/poli')->with('success','Data Berhasil Diupdate');
 
 
     }

     public function destroy($id)
     {
        $poli = Poli::find($id);
        try {
            // Hapus data poli
            $poli->delete();
    
            return redirect('/poli')->with('success','Data Berhasil Dihapus');
        } catch (\Exception $e) {
            return redirect('/poli')->with('error', 'Data Poli tidak dapat dihapus karena poli sedang digunakan.');
        }
 
     }

}
