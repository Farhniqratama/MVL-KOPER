<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Toko;
use Hash;
use DB;

class TokoController extends Controller
{
   
    public function index(){
        $data = Toko::get();
        return view('toko.index', compact('data'));
    }

    public function create()
    {   
        return view('toko.create');
    }

    public function store(Request $request)
    {   
        $us = new Toko;
        $us->nama_toko  = $request->nama_toko;
        $us->alamat  = $request->alamat;
        $us->cabang  = $request->cabang;
        $us->lat  = $request->lat;
        $us->lng  = $request->lng;
        $us->no_telp  = $request->no_telp;
        $us->save();
        
        if ($us->save()) {
            return redirect('toko')->with('success', 'Add Data Success!');
        }
        else {
            return redirect()->back()->with('error', 'Add Data Failed!');
        }
        
    }

    public function show($id)
    {
        $data = Toko::where('id', $id)->first();
        return view('toko.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $us = Toko::where('id', $id)->first();
        $us->nama_toko  = $request->nama_toko;
        $us->alamat  = $request->alamat;
        $us->cabang  = $request->cabang;
        $us->lat  = $request->lat;
        $us->lng  = $request->lng;
        $us->no_telp  = $request->no_telp;
        $us->save();

        if ($us->save()) {
            return redirect('toko')->with('success', 'Edit Data Success.!');
        }
        else {
            return redirect()->back()->with('error', 'Edit Data Failed.!');
        }
         
    }

    public function destroy($id)
    {
        $data = Toko::where('id', $id)->delete();
        return redirect('toko')->with('success', 'Delete Data Success.!');
    }
}
