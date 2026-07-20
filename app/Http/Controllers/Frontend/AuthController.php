<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

use App\Models\Pelanggan;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login() // nama function bisa bebas
    {
        $this->tes();
        
        return view("frontend.auth.login");
    }

    private function tes(){

    }

    public function doLogin(Request $request)
    {
        $checkUser = User::where('email', $request->email)
            ->get()->first();

        if (!empty($checkUser)) {
            if (Hash::check($request->password, $checkUser->password)) {
                $request->session()->put('auth_user', $checkUser->toArray());
                return redirect('/');
            }
            else{
                return redirect()->back()->with('error', 'Password yang anda masukan salah.!');
            }
        }else {
            return redirect()->back()->with('error', 'Email Tidak Terdaftar.!');
        }
    }

    public function register()
    {
        return view("frontend.auth.register");
    }

    public function doRegister(Request $request)
    {   
        $cek =  Pelanggan::where('email', $request->email)->first();
        if(!empty($cek)){
            return redirect()->back()->with('erros', 'email sudah terdaftar!');
        }
        $us = new Pelanggan();
        $us->nama = $request->nama_lengkap;
        $us->email = $request->email;
        $us->no_telp = $request->no_telp;
        $us->save();
        $last_id = $us->id;

        if ($us->save()) {

            $as = new User;
            $as->name = $request->nama_lengkap;
            $as->email = $request->email;
            $as->username = ' ';
            if(!empty($request->password)){
                $as->password = Hash::make($request->password);
            }
            $as->role = 'pelanggan';
            $as->pelanggan_id = $last_id;
            $as->save();

            return redirect('login-user')->with('success', 'Register Success!');
        
        }else{
            return redirect()->back()->with('erros', 'Email is already registered!');
        }
    }

    public function logout(Request $request)
    {
        $ss = $request->session()->forget('auth_user');
        return redirect('/');
    }

}