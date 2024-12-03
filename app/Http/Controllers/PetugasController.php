<?php

namespace App\Http\Controllers;

use App\Models\Petugas;
use Illuminate\Http\Request;

class PetugasController extends Controller
{
    public function index()
    {
        $petugas  = Petugas::all();

      
        return view('petugas',compact('petugas'));
    }

    public function store(Request $request)
    {
        Petugas::create([
            'id_petugas' => $request->id_petugas,
            'nama_petugas'=> $request->nama_petugas,
            'jabatan'=> $request->jabatan,

        ]);

        return redirect('/petugas')->with('success','Data Berhasil Disimpan');
    }

    public function update(Request $request, $id)
    {
        $user = Petugas::find($id);

        $user->id_petugas = $request->id_petugas;
        $user->nama_petugas = $request->nama_petugas;
        $user->jabatan = $request->jabatan;

        $user->save();
        return redirect('/petugas')->with('success','Data Berhasil Diupdate');


    }

    public function destroy($id)
    {
        $user = Petugas::find($id);
        $user->delete();

        return redirect('/petugas')->with('success','Data Berhasil Dihapus');

    }
}
