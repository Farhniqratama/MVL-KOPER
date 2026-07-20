<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

use App\Models\Banner;
use App\Models\GambarProduk;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Toko;
use App\Models\Chat;
use App\Models\DetailChat;
use App\Models\Kota;
use App\Models\DetailTransaksi;
use App\Models\Pelanggan;
use App\Models\AlamatPelanggan;
use App\Models\User;
use App\Models\Provinsi;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomesController extends Controller
{
    public function index()
    {
        $banner = Banner::limit(5)->orderBy('created_at', 'desc')->get();
        $produk = Produk::limit(5)->orderBy('created_at', 'desc')->get();
        $toko = Toko::get();
        $idProduk = [];
        foreach($produk as $key => $val){
            $kategori = Kategori::where('id', $val->kategori_id)->first();
            $images = GambarProduk::where('produk_id', $val->id)->where('is_thumbnails', '1')->first();
            $produk[$key]->kategori = $kategori->nama_kategori;
            $produk[$key]->gambar = $images->gambar;
            $idProduk[] = $val->id;
        }
        $terlaris = DetailTransaksi::select('produk_id', DB::raw('SUM(qty) as total_qty'))->groupBy('produk_id')->limit(4)->get();
        $prod = [];
        foreach($terlaris as $valTerlaris){
            $prod[] = $valTerlaris->produk_id;
        }

        $otherProduk = Produk::whereIn('id',$prod)->get();
        foreach($otherProduk as $key => $value){
            $kategories = Kategori::where('id', $value->kategori_id)->first();
            $image = GambarProduk::where('produk_id', $value->id)->where('is_thumbnails', '1')->first();
            $otherProduk[$key]->kategori = $kategories->nama_kategori;
            $otherProduk[$key]->gambar = $image->gambar;
        }

        $kategoriAll = Kategori::all();

        return view("frontend.home.index", compact("banner",'produk','toko','otherProduk', 'kategoriAll'));
    }

    public function getCity($province_id)
    {
        $cities = Kota::where('province_id', $province_id)->get();
        return response()->json($cities);
    }

    

    public function addChat(Request $request)
    {   
        
        $cek = Chat::where('sender_id', session('user_auth')['pelanggan_id'])->first();
        if(empty($cek)){

            $us = new Chat;
            $us->receiver_id      = 1;
            $us->sender_id      = session('user_auth')['pelanggan_id'];
            $us->save();

            $as = new DetailChat;
            $as->chat_id = $us->id;
            $as->chat_sender = $request->chat;
            $as->save();

        }else{
            $as = new DetailChat;
            $as->chat_id = $cek->id;
            $as->chat_sender = $request->chat;
            $as->save();
        }
        
        if ($as->save()) {
            return redirect('/')->with('success', 'Add Data Success!');
        }
        else {
            return redirect()->back()->with('error', 'Add Data Failed!');
        }
    }

    public function profil()
    {
        $detailData = Pelanggan::where('id', session('auth_user')['pelanggan_id'])->first();
        $alamat = AlamatPelanggan::where('pelanggan_id', session('auth_user')['pelanggan_id'])->first();
        $provinsi = Provinsi::get();
        $kota = Kota::get();
        return view("frontend.home.profil", compact('detailData','alamat','provinsi','kota'));
    }

    public function updateProfil(Request $request)
    {
        $detailData = Pelanggan::where('id', session('auth_user')['pelanggan_id'])->first();
        $detailData->nama = $request->nama;
        $detailData->email = $request->email;
        $detailData->no_telp = $request->no_telp;
        $detailData->save();

        $as = User::where('pelanggan_id', session('auth_user')['pelanggan_id'])->first();
        $as->name = $request->nama;
        $as->email = $request->email;
        $as->username = ' ';
        if(!empty($request->newPassword) and !empty($request->confirmNewPassword)){
            $as->password = Hash::make($request->newPassword);
        }
        $as->role = 'pelanggan';
        $as->save();
        $alamat = AlamatPelanggan::where('pelanggan_id', session('auth_user')['pelanggan_id'])->first();
        return redirect()->back()->with('success', 'Update Profil Berhasil.!');
    }

    public function updateAlamatProfil(Request $request)
    {
        $detailData = AlamatPelanggan::where('pelanggan_id', session('auth_user')['pelanggan_id'])->first();
        $detailData->provinsi_id = $request->provinsi_id;
        $detailData->kota_id = $request->kota_id;
        $detailData->alamat_lengkap = $request->alamat_lengkap;
        $detailData->kode_pos = $request->kode_pos;
        $detailData->save();
        return redirect()->back()->with('success', 'Update Profil Berhasil.!');
    }

    public function fetchMessages()
    {
        if (!session()->has('auth_user')) {
            return response()->json([]);
        }
        
        return DetailChat::join('chat', 'chat.id', '=', 'detail_chat.chat_id')
        ->select('detail_chat.*', 'chat.sender_id')
        ->where('sender_id', session('auth_user')['pelanggan_id'])
        ->orderBy('detail_chat.created_at', 'asc')
        ->get();
    }

    public function sendMessage(Request $request)
    {
        $request->validate(['message' => 'required|string|max:1000']);
        $cek = Chat::where('sender_id', session('auth_user')['pelanggan_id'])->first();
        if(!empty($cek)){
            $message = DetailChat::create([
                'chat_id' => $cek->id,
                'chat_sender' => $request->message,
            ]);
        }else{
            $as = new Chat;
            $as->sender_id = session('auth_user')['pelanggan_id'];
            $as->save();

            $message = DetailChat::create([
                'chat_id' => $as->id,
                'chat_sender' => $request->message,
            ]);
        }

        return response()->json(['message' => $message]);
    }

    public function notFound()
    {
        return view("frontend.home.not_found");
    }

}