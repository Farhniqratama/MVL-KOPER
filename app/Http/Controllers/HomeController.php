<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pelanggan;
use App\Models\Chat;
use App\Models\DetailChat;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Produk;
use Auth;
use PDF;
use DB;

class HomeController extends Controller
{
    public function index()
    {   
        $countP = Pelanggan::count();
        $countProd = Produk::count();
        $sumTrans = Transaksi::where('status', 4)->sum('total_pembayaran');
    	return view('home.index', compact('countP','countProd','sumTrans'));
    }

    public function getChat()
    {   
        $data = Chat::join('detail_chat as dd', 'dd.chat_id','chat.id')->select('dd.*')->get();
        $dataChat = Chat::join('pelanggan','pelanggan.id','sender_id')->select('chat.*','pelanggan.nama')->get();
        return view('home.chat', compact('data','dataChat'));
    }

    public function doAddChat(Request $request)
    {   
        $cek = Chat::where('sender_id', $request->sender_id)->first();
        
        $as = new DetailChat;
        $as->chat_id = $cek->id;
        $as->chat_receiver = $request->chat;
        $as->save();
        
        if ($as->save()) {
            return redirect('chat')->with('success', 'Add Data Success!');
        }
        else {
            return redirect()->back()->with('error', 'Add Data Failed!');
        }
    }

    public function laporan()
    {   
        $data = Transaksi::join('pelanggan','pelanggan.id','user_id')->select('transaksi.*','pelanggan.nama as nama_pelanggan')->where('status', '!=', 4)->get();

        foreach ($data as $key => $value) {
            $data[$key]->detailTransaksi = DetailTransaksi::join('produk','produk.id','produk_id')->join('gambar_produk','gambar_produk.produk_id','produk.id')->select('detail_transaksi.*','produk.nama_produk','produk.harga','gambar_produk.gambar')->where('id_transaksi', $value->id)->where('is_thumbnails', 1)->get();
        }
        return view('home.laporan', compact('data'));
    }

    public function laporanPenjualan()
    {   
        $data = Transaksi::join('pelanggan','pelanggan.id','user_id')->select('transaksi.*','pelanggan.nama as nama_pelanggan')->where('status', 4)->get();

        foreach ($data as $key => $value) {
            $data[$key]->detailTransaksi = DetailTransaksi::join('produk','produk.id','produk_id')->join('gambar_produk','gambar_produk.produk_id','produk.id')->select('detail_transaksi.*','produk.nama_produk','produk.harga','gambar_produk.gambar')->where('id_transaksi', $value->id)->where('is_thumbnails', 1)->get();
        }
        return view('home.laporanPenjualan', compact('data'));
    }

    public function laporanProduk()
    {   
        $data = Produk::join('kategori','kategori.id','kategori_id')->select('produk.*','kategori.nama_kategori')->get();
        return view('home.laporanProduk', compact('data'));
    }

    public function laporanKeuangan(Request $request)
    {   
        $sumTrans = Transaksi::where('status', 4)
            ->when(request()->has('start_date') && request()->has('end_date'), function ($query) {
                return $query->whereBetween('tgl_transaksi', [
                    request('start_date'), request('end_date')
                ]);
            })
            ->sum('total_pembayaran');
    	return view('home.laporanKeuangan', compact('sumTrans'));
    }

}
