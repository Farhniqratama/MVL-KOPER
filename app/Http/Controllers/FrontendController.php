<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Produk;
use App\Models\Pelanggan;
use App\Models\Kategori;
use App\Models\Galeri;
use App\Models\GambarProduk;
use App\Models\Cart;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\User;
use App\Models\AlamatPelanggan;
use App\Models\Kota;
use App\Models\Provinsi;
use App\Models\Chat;
use App\Models\DetailChat;
use Auth;
use PDF;
use DB;
use Illuminate\Support\Facades\Mail;

class FrontendController extends Controller
{
    public function index()
    {   
        
        $dataProduk = Produk::join('gambar_produk as gp','gp.produk_id','produk.id')->select('produk.*', 'gp.gambar as produk_gambar')->where('is_thumbnails', 1)->orderBy('id', 'desc')->limit(12)->get();
    	return view('frontend.home.index', compact('dataProduk'));
    }

    public function dataProduk()
    {   $dataProduk = Produk::join('gambar_produk as gp','gp.produk_id','produk.id')->select('produk.*', 'gp.gambar as produk_gambar')->where('is_thumbnails', 1)->orderBy('id', 'desc')->paginate(8);
        $kategori = Kategori::get();

        
        foreach ($kategori as $key => $value) {
            $detailP = Produk::join('gambar_produk as gp','gp.produk_id','produk.id')->select('produk.*', 'gp.gambar as produk_gambar')->where('is_thumbnails', 1)->where('kategori_id', $value->id)->get();
            $kategori[$key]->data_produk = $detailP;
        }

        $galeri = Galeri::orderBy('id', 'desc')->limit(6)->get();
        return view('frontend.home.produk', compact('dataProduk','kategori','galeri'));
    }

    public function detailProduk($id)
    {   $data = Produk::join('gambar_produk as gp','gp.produk_id','produk.id')->select('produk.*', 'gp.gambar as produk_gambar')->where('is_thumbnails', 1)->where('produk.id', $id)->first();

        $dataProduk = Produk::join('gambar_produk as gp','gp.produk_id','produk.id')->select('produk.*', 'gp.gambar as produk_gambar')->where('is_thumbnails', 1)->orderBy('id', 'desc')->where('produk.id','!=', $id)->paginate(8);
        $kategori = Kategori::get();
        $gambarProduk = GambarProduk::where('produk_id', $id)->get();

        return view('frontend.home.detail_produk', compact('data','dataProduk','kategori','gambarProduk'));
    }

    public function kategoriProduk($id)
    {   $dataProduk = Produk::join('gambar_produk as gp','gp.produk_id','produk.id')->select('produk.*', 'gp.gambar as produk_gambar')->where('is_thumbnails', 1)->where('kategori_id', $id)->orderBy('id', 'desc')->limit(4)->get();

        $kategori = Kategori::get();
        foreach ($kategori as $key => $value) {
            $detailP = Produk::join('gambar_produk as gp','gp.produk_id','produk.id')->select('produk.*', 'gp.gambar as produk_gambar')->where('is_thumbnails', 1)->where('kategori_id', $value->id)->get();
            $kategori[$key]->data_produk = $detailP;
        }
        $galeri = Galeri::orderBy('id', 'desc')->limit(6)->get();
        return view('frontend.home.produk', compact('dataProduk','kategori','galeri'));
    }

    public function galeri()
    {   $galeri = Galeri::orderBy('id', 'desc')->paginate(4);
        return view('frontend.home.galeri', compact('galeri'));
    }

    

    


    /*=============================== AUTH =============================*/

    public function login()
    {
        return view('frontend.auth.login');
    }

    public function doLogin(Request $request)
    {
        $checkUser = User::where('email', $request->email)
            ->get()->first();

        if (!empty($checkUser)) {
            if (Hash::check($request->password, $checkUser->password)) {
                $request->session()->put('user_auth', $checkUser->toArray());
                return redirect('/');
            }
            else{
                return redirect()->back()->with('error', 'Password yang anda masukan salah.!');
                die('Password yang anda masukan salah.!');
            }
        }else {
            return redirect()->back()->with('error', 'Email Tidak Terdaftar.!');
            die("Email Tidak Terdaftar");
        }
        debugCode($checkUser);
    }

    public function logout(Request $request)
    {
        $ss = $request->session()->forget('user_auth');
        return redirect('/');
    }

    public function register()
    {
        return view('frontend.auth.register');
    }

    public function doRegister(Request $request)
    {   
        $us = new Pelanggan;
        $us->nama  = $request->nama_lengkap;
        $us->email = $request->email;
        $us->no_telp    = $request->no_telp;
        $us->save();
        
        if ($us->save()) {

            $as = new User;
            $as->name = $request->nama_lengkap;
            $as->email = $request->email;
            if(!empty($request->password)){
                $as->password = Hash::make($request->password);
            }
            $as->role = 'pelanggan';
            $as->pelanggan_id = $us->id;
            $as->save();

            return redirect('login-user')->with('success', 'Register Success!');
        
        }else{
            return redirect()->back()->with('erros', 'Employee number is registered!');
        }

    }

    public function checkEmail()
    {
        return view('frontend.auth.checkEmail');
    }

    public function doCheckEmail(Request $request)
    {
        $checkUser = User::where('email', $request->email)->first();

        if (!empty($checkUser)) {
            return redirect('forgot-password/'.$checkUser->pelanggan_id)->with('success', 'Email Terdaftar!');
        }else {
            return redirect()->back()->with('error', 'Email Tidak Terdaftar.!');
        }
    }

    public function forgotPassword($id)
    {   
        $checkUser = Pelanggan::where('id', $id)->first();
        return view('frontend.auth.forgotPassword', compact('checkUser'));
    }

    public function doForgotPassword(Request $request)
    {
        $checkUser = User::where('pelanggan_id', $request->pelanggan_id)->first();

        if (!empty($checkUser)) {

            $as = User::where('pelanggan_id', $request->pelanggan_id)->first();
            $as->password = Hash::make($request->password);
            $as->save();

            return redirect('login-user')->with('success', 'Forgot Password Success!');
        }else {
            return redirect()->back()->with('error', 'Email Tidak Terdaftar.!');
        }
    }

}
