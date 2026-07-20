<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;

class AbsensiController extends Controller
{
   
    public function index(){
        if(session('auth_user')['role'] == 'admin'){
            $data = Absensi::join('users','users.id','user_id')->select('absensi.*','users.name')->get();
        }else{
            $data = Absensi::join('users','users.id','user_id')->select('absensi.*','users.name')->where('user_id', session('auth_user')['id'])->get();
        }
        $cek = Absensi::where('user_id', session('auth_user')['id'])->where('tgl_absensi', date('Y-m-d'))->first();
        return view('absensi.index', compact('data','cek'));
    }

    public function create()
    {   
        return view('absensi.create');
    }

    public function store(Request $request)
    {   
        date_default_timezone_set('Asia/Jakarta');

        $us = new Absensi;
        $us->user_id  = session('auth_user')['id'];
        $us->tgl_absensi     = date('Y-m-d');
        $us->jam_absensi = date('H:i:s');
        $us->save();
        
        if ($us->save()) {
            return redirect('absensi')->with('success', 'Add Data Success!');
        }
        else {
            return redirect()->back()->with('error', 'Add Data Failed!');
        }
        
    }

    public function show($id)
    {
        $data = Absensi::where('id', $id)->first();
        return view('absensi.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        //debugCode();
        $us = Absensi::where('id', $id)->first();
        $us->nama_absensi  = $request->nama_absensi;
        $us->lat     = $request->lat;
        $us->lng = $request->lng;
        $us->save();

        if ($us->save()) {
            
            return redirect('absensi')->with('success', 'Edit Data Success.!');
        }
        else {
            return redirect()->back()->with('error', 'Edit Data Failed.!');
        }
         
    }

    public function destroy($id)
    {
        $data = Absensi::where('id', $id)->delete();
        return redirect('absensi')->with('success', 'Delete Data Success.!');
    }
}
