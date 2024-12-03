<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\pasienPoli;
use App\Models\RawatJalan as ModelsRawatJalan;
use App\Models\User;
use App\Models\Penyakit;
use App\Models\Poli;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use RawatJalan;

class HomeController extends Controller
{

    // menampilkan data untuk di halaman home
    public function home()
    {
        if (auth()->user()->level == 'super_admin'){
            $pasien = pasienPoli::count();
            $diagnosa = Penyakit::count();
        } else {
            $pasien = pasienPoli::where('id_poli',Auth()->user()->id_poli)->count();
            $diagnosa = Penyakit::where('id_poli',Auth()->user()->id_poli)->count();
        }

        $user = User::count(); 

        if(auth()->user()->level != 'super_admin'){
            $pasiencontrol = ModelsRawatJalan::WhereDate('tgl_control',Carbon::now()->addDays(2)->format('Y-m-d'))
                            ->where('poli', Auth()->user()->id_poli)
                            ->where('status', 'rawat')
                            ->where('status_wa', null)
                            ->get();
            
        } else {
            $pasiencontrol = ModelsRawatJalan::whereDate('tgl_control', Carbon::now()->addDays(2)->format('Y-m-d'))
                            ->where('status', 'rawat')
                            ->where('status_wa', null)
                            ->join('poli', 'poli.id', '=', 'rawatjalan.poli')
                            ->select('rawatjalan.*', 'poli.nama_poli')
                            ->get();

        }

        return view('home',compact('user','pasien','pasiencontrol','diagnosa'));
    }

    public function kirimPesan($pasienId, $tglControl, $poli, $diagnosaId)
    {
        $pasien = pasienPoli::findOrFail($pasienId);
        $diagnosa = Penyakit::findOrFail($diagnosaId);
        
        $pesan = "REMINDER :%0AHalo " . $pasien->pasien->nama_pasien . ", Anda memiliki jadwal kontrol penyakit " .$diagnosa->nama_diagnosa. " pada tanggal " . date('d-m-Y', strtotime($tglControl)) . " di Poli " . $poli . " Puskesmas Kecamatan Pesanggrahan. Mohon pastikan Anda hadir pada Tanggal tersebut";

        $whatsappLink = "https://web.whatsapp.com/send?phone=" . $pasien->pasien->notelepon . "&text=" . $pesan;

        ModelsRawatJalan::where('id_pasien', $pasienId)
                        ->where('id_diagnosa', $diagnosaId)
                        ->update(['status_wa' => 'selesai']);

        return Redirect::away($whatsappLink);

    }

}
