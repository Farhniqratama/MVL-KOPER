<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

use App\Models\Banner;
use App\Models\GambarProduk;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Toko;
use App\Models\Review;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function dataProduk()
    {
        $produk = Produk::paginate(12);
        foreach ($produk as $key => $val) {
            $kategori = Kategori::where('id', $val->kategori_id)->first();
            $images = GambarProduk::where('produk_id', $val->id)->where('is_thumbnails', '1')->first();
            if (!$images) {
                $images = GambarProduk::where('produk_id', $val->id)->first();
            }
            $produk[$key]->gambar = $images ? $images->gambar : 'koper1.png';
        }
        return view("frontend.produk.index", compact('produk'));
    }

    public function detailProduk($id)
    {
        $produk = Produk::where('id', $id)->first();
        $kategori = Kategori::where('id', $produk->kategori_id)->first();
        $images = GambarProduk::where('produk_id', $produk->id)->get();
        $review = Review::where('produk_id', $id)->join('pelanggan', 'pelanggan.id', 'pelanggan_id')->select('review.*', 'pelanggan.nama')->get();
        $produkLainya = Produk::join('gambar_produk', 'produk_id', 'produk.id')
            ->join('kategori', 'kategori.id', 'produk.kategori_id')
            ->select('produk.*', 'gambar_produk.gambar', 'kategori.nama_kategori')
            ->where('produk.id', '!=', $id)
            ->limit('8')->get();
        return view("frontend.produk.detail_produk", compact('produk', 'kategori', 'images', 'review', 'produkLainya'));
    }

    public function kategoriProduk($id)
    {
        $produk = Produk::where('kategori_id', $id)->paginate(10);
        $kategori = '';
        $images = '';
        foreach ($produk as $key => $val) {
            $kategori = Kategori::where('id', $val->kategori_id)->first();
            $images = GambarProduk::where('produk_id', $val->id)->where('is_thumbnails', '1')->first();
            if (!$images) {
                $images = GambarProduk::where('produk_id', $val->id)->first();
            }
            $produk[$key]->kategori = $kategori ? $kategori->nama_kategori : 'Uncategorized';
            $produk[$key]->gambar = $images ? $images->gambar : 'koper2.png';
        }

        return view("frontend.produk.index", compact('produk', 'kategori', 'images'));
    }
}
