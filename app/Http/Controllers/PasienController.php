<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\Poli;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PasienExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Province;
use App\Models\Regency;
use App\Models\District;
use App\Models\pasienPoli;
use App\Models\Village;

class PasienController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     //menampilkan halaman user
     public function index()
     {
        if (auth()->user()->level == 'super_admin') {
            $pasien = pasienPoli::all();
        }else{
            $pasien  = pasienPoli::where('id_poli',auth()->user()->id_poli)->get();
        }
         
         //mendapatkan semua data poli
         $poli = Poli::all();

         // mendapatkan semua data provinsi
         $provinces = Province::orderBy('name', 'asc')->get();
         return view('pasien',compact('pasien','poli','provinces'));
     }
 
     /**
      * Show the form for creating a new resource.
      *
      * @return \Illuminate\Http\Response
      */
     public function create()
     {
         //
     }
 
     /**
      * Store a newly created resource in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @return \Illuminate\Http\Response
      */
 
      //melakukan input data user ke model yang sudah ditentukan
    //   revisiiiiiiiiiiiiiiiii
     public function store(Request $request)
     {
        // dd($request);

        $existingPasien = Pasien::where('nik_pasien', $request->nik_pasien)->first();
        
        if ($existingPasien) {
            $id_pasien = $existingPasien->id;
            // fix many to many pasien
            if(auth()->user()->level != "super_admin"){
            $sudahAda = pasienPoli::where('id_pasien', $id_pasien)
                                    ->where('id_poli', auth()->user()->id_poli)
                                    ->first();
            } else {
                $sudahAda = pasienPoli::where('id_pasien', $id_pasien)
                                        ->where('id_poli', $request->id_poli)
                                        ->first();
            }

            if($sudahAda){
                return back()->with('error', 'Pasien sudah terdaftar.');
            }

            if(auth()->user()->level != "super_admin"){
                pasienPoli::create([
                    'id_pasien' => $id_pasien,
                    'id_poli' => auth()->user()->id_poli,
                ]);
                
            } else {
                pasienPoli::create([
                    'id_pasien' => $id_pasien,
                    'id_poli' => $request->id_poli,
                ]);
            }
            return redirect('/pasien')->with('success','Data Pasien Berhasil Disimpan');
        } else {
            if (substr($request->notelepon,0,1) == '0') {
                $nohp = substr($request->notelepon,1);
            } try {
                if(auth()->user()->level != "super_admin"){
                    $newPasien = Pasien::create([
                        'nik_pasien'=> $request->nik_pasien,
                        'nama_pasien'=> $request->nama_pasien,
                        'jenis_kelamin'=> $request->jenis_kelamin,
                        'tgl_lahir' => $request->tanggal_lahir,
                        'alamat' => $request->alamat,
                        'rt' => $request->rt,
                        'rw' => $request->rw,
                        'provinsi' => $request->provinsi,
                        'kota' => $request->kabupaten,
                        'kecamatan' => $request->kecamatan,
                        'kelurahan' => $request->datakelurahan,
                        'notelepon' => '+62'.$nohp,
                        'no_bpjs'=> $request->no_bpjs
                    ]);

                    pasienPoli::create([
                        'id_pasien' => $newPasien->id,
                        'id_poli' => auth()->user()->id_poli,
                    ]);

                } else {
                    $newPasien = Pasien::create([
                        'nik_pasien'=> $request->nik_pasien,
                        'nama_pasien'=> $request->nama_pasien,
                        'jenis_kelamin'=> $request->jenis_kelamin,
                        'tgl_lahir' => $request->tanggal_lahir,
                        'alamat' => $request->alamat,
                        'rt' => $request->rt,
                        'rw' => $request->rw,
                        'provinsi' => $request->provinsi,
                        'kota' => $request->kabupaten,
                        'kecamatan' => $request->kecamatan,
                        'kelurahan' => $request->datakelurahan,
                        'notelepon' => '+62'.$nohp,
                        'no_bpjs'=> $request->no_bpjs
                    ]);

                    pasienPoli::create([
                        'id_pasien' => $newPasien->id,
                        'id_poli' => $request->id_poli,
                    ]);
                }
                return redirect('/pasien')->with('success','Data Pasien Berhasil Disimpan');
            } catch (\Exception $e) {
                return redirect('/pasien')->with('error', 'Ada Kesalahan.');
            }
        }
     }

     public function Form()
     {
        $provinces = Province::all();

        return view('form', compact('provinces'));
     }

     public function getkabupaten(Request $request)
     {
        $id_provinsi = $request->id_provinsi; 

        $kabupatens = Regency::where('province_id', $id_provinsi)->orderBy('name', 'asc')->get();
        // $kabupatens = Regency::where('id', 3171)->first();

        // $option="<option value='$kabupatens->name'>$kabupatens->name</option>";

        $option = "<option>Pilih Kabupaten...</option>";
        foreach($kabupatens as $kabupaten){
         $option.="<option value='$kabupaten->id'>$kabupaten->name</option>";
        }
 
        // echo $option;
        return response()->json(['options' => $option]);
     }
 
     public function getkecamatan(Request $request)
     {
        $id_kabupaten = $request->id_kabupaten;
 
        $kecamatans = District ::where('regency_id', $id_kabupaten)->orderBy('name', 'asc')->get();
        
        // dimana province id sama dengan req ajaxnya yaitu id provinsi lalu di get

        // $kecamatans = District ::where('id', 3171040)->first();
 
        // $option="<option value='$kecamatans->name'>$kecamatans->name</option>";

        $option = "<option>Pilih Kecamatan...</option>";
        foreach($kecamatans as $kecamatan){
 
         $option.= "<option value='$kecamatan->id'>$kecamatan->name</option>";
        }
 
        // echo $option;
        return response()->json(['options' => $option]);
 
     }
     public function getkelurahan(Request $request)
     {
        $id_kecamatan = $request->id_kecamatan;
 
        $kelurahans = Village::where('district_id', $id_kecamatan)->orderBy('name', 'asc')->get();
        // dimana province id sama dengan req ajaxnya yaitu id provinsi lalu di get
 
        // $kelurahans = WebModel::all();

        $option = "<option>Pilih Kelurahan...</option>";
        foreach($kelurahans as $kelurahan){
 
         $option.= "<option value='$kelurahan->id'>$kelurahan->name</option>";
        }
 
        // echo $option;
        return response()->json(['options' => $option]);
     }

     public function edit($id)
     {
         $item = pasienPoli::findOrFail($id);
         $id_provinsi = $item->pasien->provinsi;
         $id_kabupaten = $item->pasien->kota;
         $id_kecamatan = $item->pasien->kecamatan;
        //  $id_kelurahan = $item->pasien->kelurahan;

         //mendapatkan semua data poli
         $poli = Poli::all();

         // mendapatkan semua data provinsi
         $provinces = Province::orderBy('name', 'asc')->get();
         $regencies = Regency::where('province_id', $id_provinsi)->orderBy('name', 'asc')->get();
         $districts = District::where('regency_id', $id_kabupaten)->orderBy('name', 'asc')->get();
         $villages = Village::where('district_id', $id_kecamatan)->orderBy('name', 'asc')->get();

         return view('editPasien',compact('item','poli','provinces','regencies','districts','villages'));
     }
 
     public function update(Request $request, $id)
     {
         $user = pasienPoli::find($id);
         $pasienPoli = $user->id_pasien;

         if (substr($request->notelepon,0,1) == '0') {
            $nohp = substr($request->notelepon,1);
         }

         Pasien::where('id', $pasienPoli)->update([
            'nik_pasien'=> $request->nik_pasien,
            'nama_pasien'=> $request->nama_pasien,
            'jenis_kelamin'=> $request->jenis_kelamin,
            'tgl_lahir' => $request->tanggal_lahir,
            'alamat' => $request->alamat,
            'rt' => $request->rt,
            'rw' => $request->rw,
            'provinsi' => $request->provinsi,
            'kota' => $request->kabupaten,
            'kecamatan' => $request->kecamatan,
            'kelurahan' => $request->datakelurahan,
            'notelepon' => '+62'.$nohp,
            'no_bpjs'=> $request->no_bpjs
         ]);       
        

         //rediect ke halaman pasien
         return redirect('/pasien')->with('success','Data Pasien Berhasil Diupdate');
     }
  
     public function destroy($id)
     {
        try {
            $user = pasienPoli::findOrFail($id);
            
            // Hapus data Pasien
            $user->delete();
    
            return redirect('/pasien')->with('success', 'Data Pasien Berhasil Dihapus');
        } catch (\Exception $e) {
            return redirect('/pasien')->with('error', 'Data Pasien tidak dapat dihapus karena masih terhubung dengan rawat jalan.');
        }
     }

     // export excel
     public function exportPasien()
     {
        $userRole = Auth::user()->level;

        $query = pasienPoli::select('pasien.nik_pasien', 'pasien.nama_pasien', 'pasien.jenis_kelamin', 'pasien.tgl_lahir', 'pasien.alamat', 'pasien.rt', 'pasien.rw', 'provinces.name as province_name', 'regencies.name as regency_name', 'districts.name as district_name', 'villages.name as village_name', 'pasien.notelepon', 'pasien.no_bpjs')
        ->join('pasien','pasien.id','=','pasien_poli.id_pasien')
        ->join('provinces', 'provinces.id', '=', 'pasien.provinsi')
        ->join('regencies', 'regencies.id', '=', 'pasien.kota')
        ->join('districts', 'districts.id', '=', 'pasien.kecamatan')
        ->join('villages', 'villages.id', '=', 'pasien.kelurahan');

        if ($userRole != 'super_admin') {
            // $query->where('pasien.poli', Auth()->user()->id_poli);
            $query->where('pasien_poli.id_poli', Auth()->user()->id_poli);
            $namapoli = Auth()->user()->poli->nama_poli;
        } else {
            $namapoli = 'Keseluruhan';
        }

        $data = $query->get();        

        if($userRole != 'super_admin'){
            return Excel::download(new PasienExport($data, $namapoli), 'Data Pasien Poli '.$namapoli.'.xlsx');
        } else {
            return Excel::download(new PasienExport($data, $namapoli), 'Data Pasien Keseluruhan.xlsx');
        }
     }
 
     // melakukan penampilan detail user
     public function detailuser()
     {
         $user  = Pasien::all();
         return view('profile',compact('user'));
     }

     public function tes()
     {
        $pasien = Pasien::all();
        $poli = Poli::all();
        $data = pasienPoli::all();
        return view('tes',compact('pasien','poli','data'));
     }

     public function tesStore(Request $request)
     {
        pasienPoli::create([
            'id_pasien' => $request->id_pasien,
            'id_poli'=> $request->id_poli

        ]);

        return redirect()->back()->with('success','Data Pasien Berhasil Disimpan');
     }

     public function checkNIK(Request $request, $nik)
    {
        $data = Pasien::where('nik_pasien', $nik)->first();
        $id_provinsi = $data->provinsi;
        $id_kabupaten = $data->kota;
        $id_kecamatan = $data->kecamatan;
        $id_kelurahan = $data->kelurahan;

        $regencies = Regency::where('province_id', $id_provinsi)->orderBy('name', 'asc')->get();
        $districts = District::where('regency_id', $id_kabupaten)->orderBy('name', 'asc')->get();
        $villages = Village::where('district_id', $id_kecamatan)->orderBy('name', 'asc')->get();


        $optionKabupaten = "<option>Pilih Kabupaten...</option>";
        foreach($regencies as $kabupaten){
        //  $optionKabupaten.="<option value='$kabupaten->id' @if($kabupaten->id == $data->kota) selected @endif >$kabupaten->name</option>";
            $isSelected = $kabupaten->id == $data->kota ? 'selected' : '';
            $optionKabupaten .= "<option value='$kabupaten->id' $isSelected>$kabupaten->name</option>";
        }

        $optionKecamatan = "<option>Pilih Kecamatan...</option>";
        foreach($districts as $kecamatan){
            $isSelected = $kecamatan->id == $data->kecamatan ? 'selected' : '';
            $optionKecamatan .= "<option value='$kabupaten->id' $isSelected>$kecamatan->name</option>";
        }

        $optionKelurahan = "<option>Pilih Kelurahan...</option>";
        foreach($villages as $kelurahan){
            $isSelected = $kelurahan->id == $data->kelurahan ? 'selected' : '';
            $optionKelurahan .= "<option value='$kabupaten->id' $isSelected>$kelurahan->name</option>";
        }

        if ($data) {
            // Data ditemukan, kirimkan respon JSON
            return response()->json([
                'status' => 'success',
                'data' => $data,
                'options' => [
                    'kabupaten' => $optionKabupaten,
                    'kecamatan' => $optionKecamatan,
                    'kelurahan' => $optionKelurahan
                ]
            ]);
        } else {
            // Data tidak ditemukan
            return response()->json([
                'status' => 'not_found'
            ]);
        }
    }
}
