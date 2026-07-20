<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Hash;
use DB;

class UserController extends Controller
{
    //
    public function index(){
    	$data 	= User::where('role','!=','pelanggan')->get();
    	return view('user.index', compact('data'));
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {   
        $us = new User;
        $us->name = $request->nama;
        $us->username = $request->username;
        if(!empty($request->password)){
            $us->password = Hash::make($request->password);
        }
        $us->role = $request->role;
        if($request->role == 'employee'){
            $us->nik_employee = $request->nik;
        }
        $us->email = $request->email;
        $us->save();
       
        
        if ($us->save()) {
            return redirect('user')->with('success', 'Add Data Success!');
        }
        else {
            return redirect()->back()->with('error', 'Add Data Failed!');
        }
        
    }

    public function show($id_user)
    {
        $data = User::where('id', $id_user)->first();
        return view('user.edit', compact('data'));
    }

    public function update(Request $request, $id_user)
    {

        $us = User::where('id', $id_user)->first();
        $us->name = $request->nama;
        $us->username = $request->username;

        if(!empty($request->password)){
            $us->password = Hash::make($request->password);
        }
        
        $us->role = $request->role;
        if($request->role == 'employee'){
            $us->nik_employee = $request->nik;
        }
        $us->email = $request->email;
        $us->save();
        
        
        if ($us->save()) {
            return redirect('user')->with('success', 'Edit Data Success.!');
        }
        else {
            return redirect()->back()->with('error', 'Edit Data Failed.!');
        }
         
    }

    public function destroy($id_user)
    {
        $data = User::where('id', $id_user)->delete();
        return redirect('user')->with('success', 'Delete Data Success.!');
    }

    
}
