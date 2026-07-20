<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index(){
        $data = Banner::get();
        return view('banner.index', compact('data'));
    }

    public function create()
    {   
        return view('banner.create');
    }

    public function store(Request $request)
    {   
        $us = new Banner;
        if ($request->hasfile('image')) {
            $extension       = $request->file('image')->getClientOriginalExtension();
            $fileNameToStore = time().".".$extension;
            $path            = public_path('uploads/banner');
            $request->file('image')->move($path, $fileNameToStore);

            $us->banner = $fileNameToStore;
            $us->save();
            return response()->json(['success' => 'Image uploaded successfully.']);


        }
        
        return response()->json(['error' => 'Failed to upload image.'], 400);
        
    }

    public function show($id)
    {
        $data = Banner::where('id', $id)->first();
        return view('banner.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        //debugCode();
        $us = Banner::where('id', $id)->first();
        if ($request->hasfile('image')) {
            $extension       = $request->file('image')->getClientOriginalExtension();
            $fileNameToStore = time().".".$extension;
            $path            = public_path('uploads/banner');
            $request->file('image')->move($path, $fileNameToStore);

            $us->banner = $fileNameToStore;
            $us->save();
            return response()->json(['success' => 'Image uploaded successfully.']);

        }
        return response()->json(['error' => 'Failed to upload image.'], 400);
    }

    public function destroy($id)
    {
        $data = Banner::where('id', $id)->delete();
        return redirect('banner')->with('success', 'Delete Data Success.!');
    }
}
