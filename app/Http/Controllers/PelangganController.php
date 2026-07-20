<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggan;
use App\Models\User;
use Hash;
use DB;

class PelangganController extends Controller
{
   
    public function index(){
        $data = Pelanggan::get();
        return view('pelanggan.index', compact('data'));
    }

    public function create()
    {   
        return view('pelanggan.create');
    }

    public function store(Request $request)
    {   
        $us = new Pelanggan;
        $us->nama  = $request->nama;
        $us->email = $request->email;
        $us->no_telp    = $request->no_telp;
        $us->keterangan     = $request->keterangan;
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

            return redirect('pelanggan')->with('success', 'Add Data Success!');
        }
        else {
            return redirect()->back()->with('error', 'Add Data Failed!');
        }
        
    }

    public function show($id)
    {
        $data = Pelanggan::where('id', $id)->first();
        $user = User::where('pelanggan_id', $id)->first();
        return view('pelanggan.edit', compact('data','user'));
    }

    public function update(Request $request, $id)
    {
        //debugCode();
        $us = Pelanggan::where('id', $id)->first();
        $us->nama  = $request->nama;
        $us->email = $request->email;
        $us->no_telp    = $request->no_telp;
        $us->keterangan     = $request->keterangan;
        $us->save();

        if ($us->save()) {

            $as = User::where('pelanggan_id', $id)->first();
            $as->name = $request->nama;
            $as->email = $request->email;
            $as->username = $request->username;
            if(!empty($request->password)){
                $as->password = Hash::make($request->password);
            }
            $as->role = 'pelanggan';
            $as->save();
            return redirect('pelanggan')->with('success', 'Edit Data Success.!');
        }
        else {
            return redirect()->back()->with('error', 'Edit Data Failed.!');
        }
         
    }

    public function destroy($id)
    {
        $data = Pelanggan::where('id', $id)->delete();
        $user = User::where('pelanggan_id', $id)->delete();
        return redirect('pelanggan')->with('success', 'Delete Data Success.!');
    }
}
