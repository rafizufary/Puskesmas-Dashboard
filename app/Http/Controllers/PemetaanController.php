<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use Illuminate\Http\Request;

class PemetaanController extends Controller
{
    public function index()
    {
        return view('pages.pemetaan.index');
    }

    public function popup(Request $request){
        
        $location = $request->input('location');

    $patients = Pasien::where('kelurahan', $location)->get();

    return response()->json($patients);
    }
}
