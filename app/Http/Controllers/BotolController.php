<?php

namespace App\Http\Controllers;

use App\Models\Botol;
use Illuminate\Http\Request;

class BotolController extends Controller
{
    public function index(){
        $data = Botol::get();
        return view('botol.index', compact('data'));
    }

    public function create()
    {   
        return view('botol.create');
    }

    public function store(Request $request)
    {   
        $us = new Botol;
        $us->tipe_botol  = $request->tipe_botol;
        $us->ukuran  = $request->ukuran;
        $us->save();
        
        if ($us->save()) {
            return redirect('botol')->with('success', 'Add Data Success!');
        }
        else {
            return redirect()->back()->with('error', 'Add Data Failed!');
        }
        
    }

    public function show($id)
    {
        $data = Botol::where('id', $id)->first();
        return view('botol.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        //debugCode();
        $us = Botol::where('id', $id)->first();
        $us->tipe_botol  = $request->tipe_botol;
        $us->ukuran  = $request->ukuran;
        $us->save();

        if ($us->save()) {
            return redirect('botol')->with('success', 'Edit Data Success.!');
        }
        else {
            return redirect()->back()->with('error', 'Edit Data Failed.!');
        }
         
    }

    public function destroy($id)
    {
        $data = Botol::where('id', $id)->delete();
        return redirect('botol')->with('success', 'Delete Data Success.!');
    }
}
