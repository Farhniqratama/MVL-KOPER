<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Galeri;
use Hash;
use DB;

class GaleriController extends Controller
{
   
    public function index(){
        $data = Galeri::get();
        return view('galeri.index', compact('data'));
    }

    public function create()
    {   
        return view('galeri.create');
    }

    public function store(Request $request)
    {   
        foreach ($request->file('images') as $key => $file) {
            // loopin data image dan simpan file fisik ke folder produk
            $extension       = $file->getClientOriginalExtension();
            $fileNameToStore = time()."_".$key.'.'.$extension;
            $path            = public_path('upload/galeri/');
            $file->move($path, $fileNameToStore);

            // Insert to table
            $data = new Galeri;
            $data->gambar      = $fileNameToStore;
            $data->save();
        }
        
        if ($data->save()) {
            return redirect('galeri')->with('success', 'Add Data Success!');
        }
        else {
            return redirect()->back()->with('error', 'Add Data Failed!');
        }
        
    }

    public function show($id)
    {
        $data = Galeri::where('id', $id)->first();
        return view('galeri.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        //debugCode();
        $us = Galeri::where('id', $id)->first();

        if($request->file('images')){
            $file       = $request->file('images');
            $extention  = $file->extension();
            $galeri = date('YmdHis').'.'.$extention;
            $file->move(public_path('upload/galeri'), $galeri);

            $us->gambar   = $galeri;
        }

        $us->save();

        if ($us->save()) {
            return redirect('galeri')->with('success', 'Edit Data Success.!');
        }
        else {
            return redirect()->back()->with('error', 'Edit Data Failed.!');
        }
         
    }

    public function destroy($id)
    {
        $data = Galeri::where('id', $id)->delete();
        return redirect('galeri')->with('success', 'Delete Data Success.!');
    }
}
