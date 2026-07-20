<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

use App\Models\Cart;
use App\Models\GambarProduk;
use App\Models\Produk;
use App\Models\Pelanggan;
use App\Models\AlamatPelanggan;
use App\Models\Provinsi;
use App\Models\Kota;
use App\Models\Review;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Botol;
use App\Models\Kategori;
use App\Models\Retur;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function cart()
    {
        // Ensure session exists and has pelanggan_id
        if (!session()->has('auth_user') || !isset(session('auth_user')['pelanggan_id'])) {
            return redirect('login-user')->with('error', 'Silakan login terlebih dahulu.');
        }

        $userId = session('auth_user')['pelanggan_id'];

        // Retrieve cart items safely
        $dataCart = Cart::join('produk as p', 'p.id', '=', 'cart.produk_id')
            ->join('gambar_produk', 'gambar_produk.produk_id', '=', 'p.id')
            ->select('cart.*', 'p.nama_produk', 'p.harga', 'p.deskripsi', 'gambar_produk.gambar')
            ->where('cart.user_id', $userId)
            ->where('gambar_produk.is_thumbnails', 1)
            ->get(); // No need for ->all(), because ->get() already returns a collection

        return view('frontend.transaksi.cart', compact('dataCart'));
    }

    public function addtokeranjang(Request $request)
    {
        if (empty(session('auth_user')['pelanggan_id'])) {
            return redirect('login-user');
        }
        $us = new Cart;
        $us->produk_id = $request->produk_id;
        $us->user_id = session('auth_user')['pelanggan_id'];
        $us->qty = $request->qty;
        $us->save();

        if ($us->save()) {
            return redirect('cart')->with('success', 'Add to Cart berhasil!');
        } else {
            return redirect()->back()->with('erros', 'Add to Cart gagal!');
        }
    }

    public function addtocart($id)
    {
        if (empty(session('auth_user')['pelanggan_id'])) {
            return redirect('login-user');
        }
        $us = new Cart;
        $us->produk_id = $id;
        $us->user_id = session('auth_user')['pelanggan_id'];
        $us->qty = 1;
        $us->save();

        if ($us->save()) {
            return redirect('cart')->with('success', 'Add to Cart berhasil!');
        } else {
            return redirect()->back()->with('erros', 'Add to Cart gagal!');
        }
    }

    public function updateCart(Request $request)
    {
        if (session('auth_user')['pelanggan_id'] == '') {
            return redirect('login-customer');
        }
        foreach ($request->cart_id as $key => $value) {
            $us = Cart::where('id', $value)->first();
            $us->qty = $request->qty[$key];
            $us->save();
        }


        if ($us->save()) {
            return redirect('cart')->with('success', 'Add to Cart berhasil!');
        } else {
            return redirect()->back()->with('erros', 'Add to Cart gagal!');
        }
    }

    public function deleteCart($id)
    {
        $data = Cart::where('id', $id)->delete();
        return redirect('cart')->with('success', 'Hapus Cart berhasil.!');
    }

    public function checkout()
    {
        // Ensure the user is logged in before accessing session data
        if (!session()->has('auth_user') || !isset(session('auth_user')['pelanggan_id'])) {
            return redirect('login-user')->with('error', 'Silakan login terlebih dahulu.');
        }

        $userId = session('auth_user')['pelanggan_id'];

        // Retrieve cart items safely
        $dataCart = Cart::join('produk as p', 'p.id', '=', 'cart.produk_id')
            ->select('cart.*', 'p.nama_produk', 'p.harga', 'p.deskripsi', 'p.id as produk_id')
            ->where('cart.user_id', $userId)
            ->get(); // No need for ->all(), since ->get() already returns a collection

        // Attach product images safely
        foreach ($dataCart as $cartItem) {
            $gambarProduk = GambarProduk::where('produk_id', $cartItem->produk_id)
                ->where('is_thumbnails', 1)
                ->first();

            // Ensure the image exists before assigning it
            $cartItem->gambar_produk = $gambarProduk ? $gambarProduk->gambar : 'default-image.jpg';
        }

        // Get user details, ensuring it exists
        $detailData = Pelanggan::find($userId);

        // Get user address safely
        $alamat = AlamatPelanggan::where('pelanggan_id', $userId)->first() ?? new AlamatPelanggan();

        // Get location & bottle data
        $provinsi = Provinsi::all();
        $kota = !empty($alamat) && $alamat->provinsi_id ? Kota::where('province_id', $alamat->provinsi_id)->get() : collect();
        $botol = Botol::all();

        return view('frontend.transaksi.checkout', compact('dataCart', 'detailData', 'provinsi', 'alamat', 'kota', 'botol'));
    }

    public function docheckout(Request $request)
    {
        $cekCart = Cart::where('user_id', session('auth_user')['pelanggan_id'])->get();
        $us = new Transaksi;
        $us->kode_transaksi = "INV/" . date('Ymd') . "/" . rand(000, 999);
        $us->user_id = session('auth_user')['pelanggan_id'];
        $us->tgl_transaksi = date('Y-m-d');
        $us->total_pembayaran = $request->total_pembayaran;
        $us->metode_pembayaran = $request->payment_mmethod;
        $us->save();

        $last_id = $us->id;

        if ($us->save()) {
            foreach ($cekCart as $key => $value) {
                $cekHarga = Produk::where('id', $value->produk_id)->first();
                $dt = new DetailTransaksi;
                $dt->id_transaksi = $last_id;
                $dt->produk_id = $value->produk_id;
                $dt->harga = $cekHarga->harga;
                $dt->qty = $value->qty;
                $dt->botol_id = $request->botol_id;
                $dt->save();


            }

            $cek = AlamatPelanggan::where('pelanggan_id', session('auth_user')['pelanggan_id'])->first();

            if (!empty($cek)) {
                $cek->pelanggan_id = session('auth_user')['pelanggan_id'];
                $cek->provinsi_id = $request->provinsi_id;
                $cek->kota_id = $request->kota_id;
                $cek->alamat_lengkap = $request->alamat_lengkap;
                $cek->kode_pos = $request->kode_pos;
                $cek->save();
            } else {
                $da = new AlamatPelanggan;
                $da->pelanggan_id = session('auth_user')['pelanggan_id'];
                $da->provinsi_id = $request->provinsi_id;
                $da->kota_id = $request->kota_id;
                $da->alamat_lengkap = $request->alamat_lengkap;
                $da->kode_pos = $request->kode_pos;
                $da->save();
            }
            if ($request->payment_mmethod == 1 || $request->payment_mmethod == 2) {
                $pelanggan = Pelanggan::where('id', session('auth_user')['pelanggan_id'])->first();
                $kota = Kota::where('id', $request->kota_id)->first();
                /*============================== DUITKU ==================================*/
                
                $paymentMethod = '';
                if ($request->payment_mmethod == 2) {
                    $paymentMethod = 'SQ'; // Kode standar QRIS di Duitku API
                }

                $merchantCode = 'DS21282'; // dari duitku
                $merchantKey = 'e96dde4cff42bb75086effa0550ff25c'; // dari duitku
                $jj = (int) $request->total_pembayaran;
                $timestamp = round(microtime(true) * 1000); //in milisecond
                $paymentAmount = $jj;

                $merchantOrderId = time() . ''; // dari merchant, unique
                $productDetails = "" . $last_id . "";
                $email = $pelanggan->email; // email pelanggan merchant
                $phoneNumber = $pelanggan->no_telp; // nomor tlp pelanggan merchant (opsional)
                $additionalParam = ''; // opsional
                $merchantUserInfo = ''; // opsional
                $customerVaName = $pelanggan->nama_lengkap; // menampilkan nama pelanggan pada tampilan konfirmasi bank
                $callbackUrl = 'https://php82.aplikasiskripsi.com/rendy_parfume/calback'; // url untuk callback
                $returnUrl = 'https://php82.aplikasiskripsi.com/rendy_parfume/';//'http://example.com/return'; // url untuk redirect
                $expiryPeriod = 10; // untuk menentukan waktu kedaluarsa dalam menit
                $signature = hash('sha256', $merchantCode . $timestamp . $merchantKey);
                //$paymentMethod = 'VC'; //digunakan untuk direksional pembayaran

                // Detail pelanggan
                $firstName = $request->nama;
                $lastName = '';

                // Alamat
                $alamat = $request->alamat_lengkap;
                $city = "" . $kota->city_name . "";
                $postalCode = $request->kota_id;
                $countryCode = "ID";

                $address = array(
                    'firstName' => $firstName,
                    'lastName' => $lastName,
                    'address' => $alamat,
                    'city' => $city,
                    'postalCode' => $postalCode,
                    'phone' => $phoneNumber,
                    'countryCode' => $countryCode
                );

                $customerDetail = array(
                    'firstName' => $firstName,
                    'lastName' => $lastName,
                    'email' => $email,
                    'phoneNumber' => $phoneNumber,
                    'billingAddress' => $address,
                    'shippingAddress' => $address
                );

                $itemDetails = [];
                foreach ($request->produk_id as $keys => $values) {
                    $dataP = Produk::where('id', $values)->first();
                    $cc = array(
                        'name' => $dataP->nama_produk,
                        'price' => $request->harga[$keys],
                        'quantity' => $request->qty[$keys]
                    );

                }


                //debugCode($itemDetails);

                /*Khusus untuk metode pembayaran Kartu Kredit
                $creditCardDetail = array (
                    'acquirer' => '014',
                    'binWhitelist' => array (
                        '014',
                        '400000'
                    )
                );*/

                $params = array(
                    'paymentAmount' => $paymentAmount,
                    'merchantOrderId' => $merchantOrderId,
                    'productDetails' => $productDetails,
                    'additionalParam' => $additionalParam,
                    'merchantUserInfo' => $merchantUserInfo,
                    'customerVaName' => $customerVaName,
                    'email' => $email,
                    'phoneNumber' => $phoneNumber,
                    'itemDetails' => $itemDetails,
                    'customerDetail' => $customerDetail,
                    //'creditCardDetail' => $creditCardDetail,
                    'callbackUrl' => $callbackUrl,
                    'returnUrl' => $returnUrl,
                    'expiryPeriod' => $expiryPeriod
                );

                if (!empty($paymentMethod)) {
                    $params['paymentMethod'] = $paymentMethod;
                }

                $params_string = json_encode($params);

                //echo $params_string;
                $url = 'https://api-sandbox.duitku.com/api/merchant/createinvoice'; // Sandbox
                // $url = 'https://api-prod.duitku.com/api/merchant/createinvoice'; // Production

                //log transaksi untuk debug 
                // file_put_contents('log_createInvoice.txt', "* log *\r\n", FILE_APPEND | LOCK_EX);
                // file_put_contents('log_createInvoice.txt', $params_string . "\r\n\r\n", FILE_APPEND | LOCK_EX);
                // file_put_contents('log_createInvoice.txt', 'x-duitku-signature:' . $signature . "\r\n\r\n", FILE_APPEND | LOCK_EX);
                // file_put_contents('log_createInvoice.txt', 'x-duitku-timestamp:' . $timestamp . "\r\n\r\n", FILE_APPEND | LOCK_EX);
                // file_put_contents('log_createInvoice.txt', 'x-duitku-merchantcode:' . $merchantCode . "\r\n\r\n", FILE_APPEND | LOCK_EX);
                $ch = curl_init();


                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $params_string);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt(
                    $ch,
                    CURLOPT_HTTPHEADER,
                    array(
                        'Content-Type: application/json',
                        'Content-Length: ' . strlen($params_string),
                        'x-duitku-signature:' . $signature,
                        'x-duitku-timestamp:' . $timestamp,
                        'x-duitku-merchantcode:' . $merchantCode
                    )
                );

                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

                //execute post
                $requests = curl_exec($ch);
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                //debugCode($requests);

                if ($httpCode == 200) {
                    $result = json_decode($requests, true);

                    print_r($result, false);
                    echo "paymentUrl :" . $result['paymentUrl'] . "<br />";
                    echo "reference :" . $result['reference'] . "<br />";
                    echo "statusCode :" . $result['statusCode'] . "<br />";
                    echo "statusMessage :" . $result['statusMessage'] . "<br />";
                    echo "transaksi_id :" . $last_id . "<br />";

                    $cekTr = Transaksi::where('id', $last_id)->first();
                    $cekTr->reference = $result['reference'];
                    $cekTr->save();

                    $cart = Cart::where('user_id', session('auth_user')['pelanggan_id'])->delete();
                    //header('location: '. $result['paymentUrl']);
                    return redirect($result['paymentUrl']);
                } else {
                    echo $httpCode . " " . $request;
                    echo $request;
                    
                    // Fallback jika API Duitku gagal
                    if ($request->payment_mmethod == 2) {
                        return redirect('bayar-qr/' . $last_id)->with('success', 'Checkout berhasil! Silahkan Lakukan Pembayaran Manual');
                    }
                    return redirect('bayar/' . $last_id)->with('success', 'Checkout berhasil! Silahkan Lakukan Pembayaran Manual');
                }
            } else {
                $cart = Cart::where('user_id', session('auth_user')['pelanggan_id'])->delete();

                return redirect('bayar-cod/' . $last_id)->with('success', 'Checkout berhasil! Silahkan Lakukan Pembayaran');
            }

            /*================================ END DUITKU ============================*/
        } else {
            return redirect()->back()->with('erros', 'Checkout gagal!');
        }
    }

    public function bayar($id)
    {
        $dataTransaksi = Transaksi::where('transaksi.id', $id)->first();
        $dataUser = Pelanggan::where('pelanggan.id', session('auth_user')['pelanggan_id'])->join('alamat_pelanggan as ua', 'ua.pelanggan_id', 'pelanggan.id')->select('pelanggan.*', 'ua.kota_id', 'ua.alamat_lengkap')->first();
        $detailTr = DetailTransaksi::join('produk as p', 'p.id', 'detail_transaksi.produk_id')->select('detail_transaksi.*', 'p.nama_produk')->where('id_transaksi', $id)->get();

        $kota = Kota::where('id', $dataUser->kota_id)->first();
        $merchantCode = 'DS21282'; // dari duitku
        $merchantKey = 'e96dde4cff42bb75086effa0550ff25c'; // dari duitku
        $jj = (int) $dataTransaksi->total_pembayaran;
        $timestamp = round(microtime(true) * 1000); //in milisecond
        $paymentAmount = $jj;

        $merchantOrderId = time() . ''; // dari merchant, unique
        $productDetails = "" . $dataTransaksi->id . "";
        $email = $dataUser->email; // email pelanggan merchant
        $phoneNumber = "" . $dataUser->no_telp . ""; // nomor tlp pelanggan merchant (opsional)
        $additionalParam = ''; // opsional
        $merchantUserInfo = ''; // opsional
        $customerVaName = $dataUser->nama; // menampilkan nama pelanggan pada tampilan konfirmasi bank
        $callbackUrl = 'https://php82.aplikasiskripsi.com/rendy_parfum/calback'; // url untuk callback
        $returnUrl = 'https://php82.aplikasiskripsi.com/rendy_parfum/';//'http://example.com/return'; // url untuk redirect
        $expiryPeriod = 10; // untuk menentukan waktu kedaluarsa dalam menit
        $signature = hash('sha256', $merchantCode . $timestamp . $merchantKey);
        //$paymentMethod = 'VC'; //digunakan untuk direksional pembayaran

        // Detail pelanggan
        $firstName = "" . $dataUser->nama . "";
        $lastName = '';

        // Alamat
        $alamat = "" . $dataUser->alamat_lengkap . "";
        $city = "" . $kota->city_name . "";
        $postalCode = "" . $dataUser->kota_id . "";
        $countryCode = "ID";

        $address = array(
            'firstName' => $firstName,
            'lastName' => $lastName,
            'address' => $alamat,
            'city' => $city,
            'postalCode' => $postalCode,
            'phone' => $phoneNumber,
            'countryCode' => $countryCode
        );

        $customerDetail = array(
            'firstName' => $firstName,
            'lastName' => $lastName,
            'email' => $email,
            'phoneNumber' => $phoneNumber,
            'billingAddress' => $address,
            'shippingAddress' => $address
        );

        $itemDetails = [];
        $cc = [];
        foreach ($detailTr as $keys => $values) {
            $dataP = Produk::where('id', $values->produk_id)->first();
            $cc = array(
                'name' => $dataP->nama_produk,
                'price' => $values->harga,
                'quantity' => $values->qty
            );

        }

        //debugCode($itemDetails);

        /*Khusus untuk metode pembayaran Kartu Kredit
        $creditCardDetail = array (
            'acquirer' => '014',
            'binWhitelist' => array (
                '014',
                '400000'
            )
        );*/

        $params = array(
            'paymentAmount' => $paymentAmount,
            'merchantOrderId' => $merchantOrderId,
            'productDetails' => $productDetails,
            'additionalParam' => $additionalParam,
            'merchantUserInfo' => $merchantUserInfo,
            'customerVaName' => $customerVaName,
            'email' => $email,
            'phoneNumber' => $phoneNumber,
            'itemDetails' => $itemDetails,
            'customerDetail' => $customerDetail,
            //'creditCardDetail' => $creditCardDetail,
            'callbackUrl' => $callbackUrl,
            'returnUrl' => $returnUrl,
            'expiryPeriod' => $expiryPeriod
            //'paymentMethod' => $paymentMethod
        );
        //debugCode($params);
        $params_string = json_encode($params);

        //echo $params_string;
        $url = 'https://api-sandbox.duitku.com/api/merchant/createinvoice'; // Sandbox
        // $url = 'https://api-prod.duitku.com/api/merchant/createinvoice'; // Production

        //log transaksi untuk debug 
        // file_put_contents('log_createInvoice.txt', "* log *\r\n", FILE_APPEND | LOCK_EX);
        // file_put_contents('log_createInvoice.txt', $params_string . "\r\n\r\n", FILE_APPEND | LOCK_EX);
        // file_put_contents('log_createInvoice.txt', 'x-duitku-signature:' . $signature . "\r\n\r\n", FILE_APPEND | LOCK_EX);
        // file_put_contents('log_createInvoice.txt', 'x-duitku-timestamp:' . $timestamp . "\r\n\r\n", FILE_APPEND | LOCK_EX);
        // file_put_contents('log_createInvoice.txt', 'x-duitku-merchantcode:' . $merchantCode . "\r\n\r\n", FILE_APPEND | LOCK_EX);
        $ch = curl_init();


        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($params_string),
                'x-duitku-signature:' . $signature,
                'x-duitku-timestamp:' . $timestamp,
                'x-duitku-merchantcode:' . $merchantCode
            )
        );

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        //execute post
        $requests = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        //debugCode($requests);

        if ($httpCode == 200) {
            $result = json_decode($requests, true);

            //print_r($result, false);
            echo "paymentUrl :" . $result['paymentUrl'] . "<br />";
            echo "reference :" . $result['reference'] . "<br />";
            echo "statusCode :" . $result['statusCode'] . "<br />";
            echo "statusMessage :" . $result['statusMessage'] . "<br />";
            echo "transaksi_id :" . $id . "<br />";

            $cekTr = Transaksi::where('id', $id)->first();
            $cekTr->reference = $result['reference'];
            $cekTr->save();

            //header('location: '. $result['paymentUrl']);
            return redirect($result['paymentUrl']);
        } else {
            echo $httpCode . " " . $requests;
            echo $requests;
        }
        die();
    }

    public function bayarQr($id)
    {
        $data = Transaksi::where('id', $id)->first();
        $id_transaksi = $id;
        return view('frontend.transaksi.bayar', compact('data', 'id_transaksi'));
    }

    public function bayarCod($id)
    {
        $data = Transaksi::where('id', $id)->first();
        $id_transaksi = $id;
        return view('frontend.transaksi.bayarCod', compact('data', 'id_transaksi'));
    }

    public function dobayar(Request $request)
    {
        $data = Transaksi::where('id', $request->id_transaksi)->first();
        $data->status = 1;
        if ($request->hasfile('image')) {
            $extension = $request->file('image')->getClientOriginalExtension();
            $fileNameToStore = time() . "." . $extension;
            $path = public_path('images/bukti_bayar');
            $request->file('image')->move($path, $fileNameToStore);

            $data->bukti_tf = $fileNameToStore;
        }
        $data->save();
        return redirect('histori-transaksi')->with('success', 'Pembayaran berhasil dilakukan');
    }

    public function calback(Request $request)
    {
        $cek = Transaksi::where('reference', $request->reference)->first();
        if ($request->resultCode == 00) {
            $cek->status = 1;
        } else if ($request->resultCode == 01) {
            $cek->status = 0;
        } else {
            $cek->status = 0;
        }
        $cek->save();

        return view('frontend.transaksi.historiTransaksi');
    }

    public function historiTransaksi()
    {
        $data = Transaksi::where('user_id', session('auth_user')['pelanggan_id'])->orderBy('status')->get();

        foreach ($data as $key => $value) {
            $data[$key]->detailTransaksi = DetailTransaksi::join('produk', 'produk.id', 'produk_id')
                ->join('botol', 'botol.id', 'detail_transaksi.botol_id')
                ->join('gambar_produk', 'gambar_produk.produk_id', 'produk.id')
                ->select('detail_transaksi.*', 'produk.nama_produk', 'produk.harga', 'gambar_produk.gambar', 'botol.tipe_botol', 'botol.ukuran')
                ->where('id_transaksi', $value->id)->where('is_thumbnails', 1)
                ->get();
        }

        $retur = Retur::join('transaksi', 'transaksi.id', 'transaksi_id')->select('transaksi.*', 'retur.status as status_retur')->where('user_id', session('auth_user')['pelanggan_id'])->where('transaksi.status', 6)->get();
        foreach ($retur as $key => $value) {
            $retur[$key]->detailTransaksi = DetailTransaksi::join('produk', 'produk.id', 'produk_id')
                ->join('botol', 'botol.id', 'detail_transaksi.botol_id')
                ->join('gambar_produk', 'gambar_produk.produk_id', 'produk.id')
                ->select('detail_transaksi.*', 'produk.nama_produk', 'produk.harga', 'gambar_produk.gambar', 'botol.tipe_botol', 'botol.ukuran')
                ->where('id_transaksi', $value->id)->where('is_thumbnails', 1)
                ->get();
        }
        return view('frontend.transaksi.historiTransaksi', compact('data', 'retur'));
    }

    public function terimaPesanan(Request $request, $id)
    {
        $data = Transaksi::where('id', $id)->first();
        $data->status = 4;
        $data->save();

        return redirect('histori-transaksi')->with('success', 'Update Status Pemesanan berhasil!');
    }

    public function batalkanPesanan(Request $request, $id)
    {
        $data = Transaksi::where('id', $id)->first();

        return view('frontend.transaksi.batalkanPesanan', compact('data'));
    }

    public function doBatalkanPesanan(Request $request)
    {
        $data = Transaksi::where('id', $request->id_transaksi)->first();
        $data->status = 5;
        $data->keterangan_batal = $request->message;
        $data->save();

        return redirect('histori-transaksi')->with('success', 'Pembatalan Pemesanan berhasil!');
    }

    public function returPesanan(Request $request, $id)
    {
        $data = Transaksi::where('id', $id)->first();

        return view('frontend.transaksi.returPesanan', compact('data'));
    }

    public function doReturPesanan(Request $request)
    {
        $data = Transaksi::where('id', $request->id_transaksi)->first();
        $data->status = 6;
        $data->save();

        $as = new Retur;
        $as->transaksi_id = $request->id_transaksi;
        if ($request->hasfile('image')) {
            $extension = $request->file('image')->getClientOriginalExtension();
            $fileNameToStore = time() . "." . $extension;
            $path = public_path('images/retur');
            $request->file('image')->move($path, $fileNameToStore);

            $as->gambar = $fileNameToStore;
        }
        $as->keterangan = $request->message;
        $as->save();
        return redirect('histori-transaksi')->with('success', 'Pembatalan Pemesanan berhasil!');
    }

    public function updateQuantity(Request $request)
    {
        $item = Cart::find($request->id);
        if ($item) {
            $item->qty = $request->qty;
            //$item->total_payment = $request->total;
            $item->save();

            return response()->json([
                'success' => true,
                'message' => 'Quantity updated successfully',
                'data' => $item
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Item not found'
        ], 404);
    }

    public function getKurir(Request $request)
    {
        $data['param'] = array(
            'origin_city' => $request->asal,
            'destination_sub' => $request->tujuan,
            'item_weight' => $request->berat,
            'type' => $request->kurir,
        );
        $dataOngkir = $this->getOngkir($data['param']);

        $tmp = "";
        if (!empty($dataOngkir)) {
            $code_kurir = $dataOngkir['rajaongkir']['results'][0]['code'];
            foreach ($dataOngkir['rajaongkir']['results'][0]['costs'] as $value) {
                $cost = $value['cost'][0];
                $tmp .= "<tr>";
                $tmp .= "<td>" . $code_kurir . "</td>";
                $tmp .= "<td>" . $value['service'] . "</td>";
                $tmp .= "<td>" . "Rp. " . number_format($cost['value'], 0, ',', '.') . "</td>";
                $tmp .= "<td>" . $cost['etd'] . " </td>";
                $tmp .= '<td><input type="radio" name="jasaPengiriman" class="shipping-cost-radio" value="' . $cost['value'] . '" data-service="' . $value['service'] . '">' . "</td>";
                $tmp .= "</tr>";
            }
        }

        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Expose-Headers: Access-Control-Allow-Origin');
        header("HTTP/1.1 200 OK");
        header('Content-Type: application/json');
        echo $tmp;
    }


    public function getOngkir($data)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 2, // Dikurangi dari 15 ke 2 detik agar proses fallback sangat cepat
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "origin=" . $data['origin_city'] . "&destination=" . $data['destination_sub'] . "&weight=" . $data['item_weight'] . "&courier=" . $data['type'],
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded",
                "key: 84a5d0137490644d28a0cc74c2d497d2"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        if ($err || empty($response)) {
            // Fallback MOCK RESPONSE for Local Development if RajaOngkir blocks IP
            return [
                'rajaongkir' => [
                    'results' => [
                        [
                            'code' => strtoupper($data['type']),
                            'costs' => [
                                [
                                    'service' => 'REG (Mock/Local)',
                                    'cost' => [
                                        [
                                            'value' => 25000,
                                            'etd' => '2-3 Hari'
                                        ]
                                    ]
                                ],
                                [
                                    'service' => 'EXPRESS (Mock/Local)',
                                    'cost' => [
                                        [
                                            'value' => 45000,
                                            'etd' => '1 Hari'
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ];
        } else {
            return json_decode($response, true);
        }
    }

    public function ulasProduk(Request $request, $id)
    {
        $data = Transaksi::where('id', $id)->first();
        $detail = DetailTransaksi::where('id_transaksi', $id)
            ->join('produk', 'produk.id', 'produk_id')
            ->select('produk.*')
            ->get();
        foreach ($detail as $key => $value) {
            $gambar = GambarProduk::where('produk_id', $value->id)->where('is_thumbnails', 1)->first();

            $detail[$key]->gambar = $gambar->gambar;
        }
        return view('frontend.transaksi.ulasProduk', compact('detail', 'data'));
    }

    public function doAddReview(Request $request, $id)
    {
        $us = new Review;
        $us->produk_id = $id;
        $us->pelanggan_id = session('auth_user')['pelanggan_id'];
        $us->rating = $request->stars;
        $us->review = $request->comment;
        $us->save();

        return redirect('histori-transaksi')->with('success', 'Pembayaran berhasil dilakukan');
    }

}