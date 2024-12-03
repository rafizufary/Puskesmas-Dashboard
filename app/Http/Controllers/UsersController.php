<?php

namespace App\Http\Controllers;

use App\Models\Poli;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UserExport;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
date_default_timezone_set('Asia/Jakarta');


class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function exportUser()
     {
        return Excel::download(new UserExport, 'Data User.xlsx');
     }

     //menampilkan halaman user
    public function index()
    {
        $user = User::all();
        
        $poli = Poli::all();


        return view('admin.master.user.user',compact('user','poli'));
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
    public function store(Request $request)
    {
        User::create([
            'name'=> $request->name,
            'email'=> $request->email,
            'password'=>bcrypt($request->password),
            'level' => $request->level,
            'id_poli' => $request->poli,
            'created_at' => $request->created_at,
            'updated_at'=> $request->updated_at,

        ]);

        return redirect('/user')->with('success','Data Berhasil Disimpan');
    }
 
    //melakukan update user berdasarkan id yang didapatkan dari parameter
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        $user->name         = $request->name;
        $user->email        = $request->email;
        $user->password     = bcrypt($request->password);
        $user->level        = $request->level;
        $user->id_poli      = $request->poli;
        $user->created_at   = $request->created_at;
        $user->updated_at   = $request->updated_at;

        $user->save();
        return redirect('/user')->with('success','Data Berhasil Diupdate');


    }

 
    //melakukan hapus user berdasarkan id yang didapatkan
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        return redirect('/user')->with('success','Data Berhasil Dihapus');

    }


    // melakukan penampilan detail user
    public function detailuser()
    {
        $user  = User::all();
        return view('profile',compact('user'));
    }
}
