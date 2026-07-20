<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use Hash;
use DB;

class KategoriController extends Controller
{
   
    public function index(){
        $data = Kategori::get();
        return view('kategori.index', compact('data'));
    }

    public function create()
    {   
        return view('kategori.create');
    }

    public function store(Request $request)
    {   
        $us = new Kategori;
        $us->nama_kategori  = $request->nama_kategori;
        $us->save();
        
        if ($us->save()) {
            return redirect('kategori')->with('success', 'Add Data Success!');
        }
        else {
            return redirect()->back()->with('error', 'Add Data Failed!');
        }
        
    }

    public function show($id)
    {
        $data = Kategori::where('id', $id)->first();
        return view('kategori.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        //debugCode();
        $us = Kategori::where('id', $id)->first();
        $us->nama_kategori  = $request->nama_kategori;
        $us->save();

        if ($us->save()) {
            return redirect('kategori')->with('success', 'Edit Data Success.!');
        }
        else {
            return redirect()->back()->with('error', 'Edit Data Failed.!');
        }
         
    }

    public function destroy($id)
    {
        $data = Kategori::where('id', $id)->delete();
        return redirect('kategori')->with('success', 'Delete Data Success.!');
    }
}
