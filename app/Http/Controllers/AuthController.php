<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;



class AuthController extends Controller
{

    //menampilkan halaman index
    public function index()
    {
        return view('index',[
    'title'=>'login',
    'active'=>'login']);
    }


    //melakukan auth pada login
    public function authenticate(Request $request)
    {
        //jika sukses akan masuk kehalaman home
       if(Auth::attempt($request->only('email','password'))){
            return redirect('/home');
        }

       return back()->with('error','Login gagal');

    }

    //fungsi untuk logout
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
