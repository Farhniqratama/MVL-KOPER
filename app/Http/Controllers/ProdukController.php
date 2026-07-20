<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\GambarProduk;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class ProdukController extends Controller
{
   
    public function index()
    {        
        $data = Produk::join('kategori','kategori.id','kategori_id')->select('produk.*','kategori.nama_kategori')->get();
       
        return view('produk.index', compact('data'));
    }

    public function create()
    {   
        $kategori = Kategori::get();
        return view('produk.create', compact('kategori'));
    }

    public function store(Request $request)
    {   
        $us = new Produk;
        $us->kd_produk = $request->kd_produk;
        $us->kategori_id    = $request->kategori_id;
        $us->nama_produk    = $request->nama_produk;
        $us->harga          = $request->harga;
        $us->deskripsi      = $request->deskripsi;

        if($request->file('image')){
            $file       = $request->file('image');
            $extention  = $file->extension();
            $selfie = date('YmdHis').'.'.$extention;
            $file->move(public_path('upload/produk'), $selfie);

            $us->gambar   = $selfie;
        }
        $us->save();
        
        if ($us->save()) {
            return redirect('produk')->with('success', 'Add Data Success!');
        }
        else {
            return redirect()->back()->with('error', 'Add Data Failed!');
        }
        
    }

    public function show($id)
    {
        $data = Produk::where('id', $id)->first();
        $kategori = Kategori::get();
        return view('produk.edit', compact('data','kategori'));
    }

    public function update(Request $request, $id)
    {   
        $us = Produk::where('id', $id)->first();
        $us->kd_produk = $request->kd_produk;
        $us->kategori_id    = $request->kategori_id;
        $us->nama_produk    = $request->nama_produk;
        $us->harga          = $request->harga;
        $us->deskripsi      = $request->deskripsi;

        if($request->file('image')){
            $file       = $request->file('image');
            $extention  = $file->extension();
            $selfie = date('YmdHis').'.'.$extention;
            $file->move(public_path('upload/produk'), $selfie);

            $us->gambar   = $selfie;
        }
        $us->save();

        if ($us->save()) {
            
            return redirect('produk')->with('success', 'Edit Data Success.!');
        }
        else {
            return redirect()->back()->with('error', 'Edit Data Failed.!');
        }
         
    }

    public function destroy($id)
    {
        $data = Produk::where('id', $id)->delete();
        return redirect('produk')->with('success', 'Delete Data Success.!');
    }

    public function autonumber(){
        $id = 'id';
        DB::enableQueryLog();
        $q=DB::table('produk')->select(DB::raw('MAX(id) as kd_max'));
        $query = DB::getQueryLog();
        //debugCode($query);
        $prx= 'AFB'.date('dmy');
        if($q->count()>0)
        {
            foreach($q->get() as $k)
            {   
                
                $tmp = ((int)$k->kd_max)+1;
                $kd = $prx.sprintf("%06s", $tmp);
            }
        }
        else
        {
            $kd = $prx."000001";
        }

        return $kd;
    }

    public function productImageIndex($produk_id)
    {
        $product = Produk::find($produk_id);
        $data    = GambarProduk::where('produk_id', $produk_id)->get()->all();
        return view('produk.images', compact('product', 'data'));
    }

    public function doUploadProductImages(Request $request, $produk_id)
    {
        $request->validate([
            'cropped_images.*' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $product = Produk::find($produk_id);

        // Array untuk menyimpan path gambar yang telah di-upload
        $imagePaths = [];

        if ($request->hasFile('cropped_images')) {
            // Proses setiap gambar yang di-crop
            foreach ($request->file('cropped_images') as $key => $image) {

                $extension       = $image->getClientOriginalExtension();
                $fileNameToStore = time()."_".$key.'.'.$extension;
                $path            = public_path('upload/produk/');
                $image->move($path, $fileNameToStore);

                // Jika perlu, simpan path gambar ke database
                $product->images()->create([
                    'produk_id' => $product->id,
                    'gambar' => $fileNameToStore,
                    'is_thumbnails' => 0,
                ]);
            }
            return response()->json(['message' => 'Semua gambar berhasil di-upload', 'imagePaths' => $imagePaths]);

            //return redirect()->back()->with('error', 'Upload gambar berhasil.!');
        }
        return response()->json(['message' => 'Gagal mengupload gambar.'], 400);
    }

    public function setAsThumbnail($id, $produk_id)
    {
        // fungsi seting image menjadi default 
        GambarProduk::where('produk_id', $produk_id)->update(['is_thumbnails' => 0]);
        GambarProduk::where('id', $id)->update(['is_thumbnails' => 1]);
        return redirect()->back()->with('success', 'Set Thumbnails success.!');
    }

    public function destroyImage($id, $produk_id)
    {
        // delete gambar produk
        GambarProduk::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Remove Image Success.!');
    }

}
