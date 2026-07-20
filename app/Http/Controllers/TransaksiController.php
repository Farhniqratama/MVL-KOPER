<?php

namespace App\Http\Controllers;

use App\Models\Retur;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pelanggan;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use Auth;
use PDF;
use DB;
use Illuminate\Support\Facades\Mail;

class TransaksiController extends Controller
{
    public function index()
    {   
        $data = Transaksi::join('pelanggan','pelanggan.id','user_id')->select('transaksi.*','pelanggan.nama as nama_pelanggan')->get();
        
        foreach ($data as $key => $value) {
            $data[$key]->detailTransaksi = DetailTransaksi::join('produk','produk.id','produk_id')->join('gambar_produk','gambar_produk.produk_id','produk.id')->select('detail_transaksi.*','produk.nama_produk','produk.harga','gambar_produk.gambar')->where('id_transaksi', $value->id)->where('is_thumbnails', 1)->get();

            if($value->status == 6){
                $retur = Retur::where('transaksi_id', $value->id)->first();
                $data[$key]->status_retur = $retur->status;
            }
            
        }
    	return view('transaksi.index', compact('data'));
    }

    public function detail($id)
    {   
        $data = Transaksi::join('pelanggan','pelanggan.id','user_id')->select('transaksi.*','pelanggan.nama as nama_pelanggan')->where('transaksi.id', $id)->first();

        $detailTransaksi = DetailTransaksi::join('produk','produk.id','produk_id')->join('gambar_produk','gambar_produk.produk_id','produk.id')->join('botol','botol.id','botol_id')->select('detail_transaksi.*','produk.nama_produk','produk.harga','gambar_produk.gambar','botol.tipe_botol','botol.ukuran')->where('id_transaksi', $id)->where('is_thumbnails', 1)->get();
        $retur = '';
        if($data->status == 6){
            $retur = Retur::where('transaksi_id', $data->id)->first();
            return view('transaksi.detailRetur', compact('data','detailTransaksi','retur'));
        }
        return view('transaksi.detail', compact('data','detailTransaksi','retur'));
    }

    public function updateTransaksi(Request $request, $id)
    {   
        $retur = Transaksi::where('id', $id)->first();
        $retur->status = $request->status;
        $retur->alasan_penolakan = $request->alasan_penolakan;
        $retur->save();

        $transaksi = Transaksi::where('id', $id)->first();
        if($request->status == 1){
            $pesan = 'Terimakasih, Retur Produk Anda akan kami prosses';
        }elseif($request->status == 2){
            $pesan = 'Retur Pesanan kamu berhasil dilakukan';
        }else{
            $pesan = 'Pesanan kamu dengan no '.$transaksi->kode_transaksi.' Telah kami kirimkan';
        }

        $pelanggan = Pelanggan::where('id', $transaksi->user_id)->first();
        $data = [
            'name'  => $pelanggan->nama,
            'email' => $pelanggan->email,
            'text'  => $pesan
        ];
        Mail::send('email_isi', $data, function ($message) use ($data) {
            $message->to($data['email'], $data['name'])
                    ->subject('Informasi');
        });
        
        return redirect('transaksi')->with('success', 'Update Status Pemesanan berhasil!');
    }

    public function updateTransaksiRetur(Request $request, $id)
    {   
        $retur = Retur::where('transaksi_id', $id)->first();
        $retur->status = $request->status;
        if(!empty($request->alasan_penolakan)){
            $retur->alasan_penolakan = $request->alasan_penolakan;
        }
        $retur->save();

        $transaksi = Transaksi::where('id', $id)->first();
        if($request->status == 1){
            $pesan = 'Terimakasih, Retur Produk Anda akan kami prosses';
        }elseif($request->status == 2){
            $pesan = 'Retur Pesanan kamu berhasil dilakukan';
        }else{
            $pesan = 'Pesanan kamu dengan no '.$transaksi->kode_transaksi.' Telah kami kirimkan';
        }

        $pelanggan = Pelanggan::where('id', $transaksi->user_id)->first();
        $data = [
            'name'  => $pelanggan->nama,
            'email' => $pelanggan->email,
            'text'  => $pesan
        ];
        Mail::send('email_isi', $data, function ($message) use ($data) {
            $message->to($data['email'], $data['name'])
                    ->subject('Informasi');
        });
        
        return redirect('transaksi')->with('success', 'Update Status Pemesanan berhasil!');
    }

}
