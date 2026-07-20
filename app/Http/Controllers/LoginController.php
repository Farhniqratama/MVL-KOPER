<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Pelanggan;


class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function doLogin(Request $request)
    {
        $checkUser = User::where('username', $request->username)
            ->get()->first();  // untuk mengambil data

            // select * from users where username = 'admin'
        // dd($checkKaryawan);
        
        if (!empty($checkUser)) { // jika data users ada maka
            if (Hash::check($request->password, $checkUser->password)) { // penngecekan untuk password
                $request->session()->put('auth_user', $checkUser->toArray());
                return redirect('/dashboard');
            }
            else{ // jika tidak ada maka
                return redirect()->back()->with('error', 'Password yang anda masukan salah.!');
            }
        }else {
            return redirect()->back()->with('error', 'Username Tidak Terdaftar.!');
        }
    }

    public function logout(Request $request)
    {
        $ss = $request->session()->forget('auth_user');
        return redirect('/dashboard');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function doRegister(Request $request)
    {   
        $us = new Pelanggan;
        $us->nama  = $request->nama;
        $us->email = $request->email;
        $us->no_telp    = $request->no_telp;
        //$us->keterangan     = $request->keterangan;
        $us->save();
        
        if ($us->save()) {

            $as = new User;
            $as->name = $request->nama;
            $as->email = $request->email;
            $as->username = $request->username;
            if(!empty($request->password)){
                $as->password = Hash::make($request->password);
            }
            $as->role = 'pelanggan';
            $as->pelanggan_id = $us->id;
            $as->save();

            return redirect('login')->with('success', 'Register Success!');
        
        }else{
            return redirect()->back()->with('erros', 'Employee number is registered!');
        }

    }
}
