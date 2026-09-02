<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Define your controller below
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\TokoController;
use App\Http\Controllers\BotolController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\DataScienceController;

use App\Http\Controllers\Frontend\HomesController;
use App\Http\Controllers\Frontend\AuthController;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Frontend\TransactionController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomesController::class, 'index']);
Route::get('getCity/{id}', [HomesController::class, 'getCity']);
Route::post('add-chat', [HomesController::class, 'addChat']);
Route::get('profil', [HomesController::class, 'profil']);
Route::post('update-profile', [HomesController::class, 'updateProfil']);
Route::post('update-alamat-profile', [HomesController::class, 'updateAlamatProfil']);
Route::get('/messages', [HomesController::class, 'fetchMessages']);
Route::post('/send-messages', [HomesController::class, 'sendMessage']);

Route::get('/list-produk', [ProductController::class, 'dataProduk']);
Route::get('/produk-detail/{id}', [ProductController::class, 'detailProduk']);
Route::get('/kategori-produk', [ProductController::class, 'dataProduk']);
Route::get('/produk-by-kategori/{id}', [ProductController::class, 'kategoriProduk']);

Route::get('cart', [TransactionController::class, 'cart']);
Route::post('add-to-keranjang', [TransactionController::class, 'addtokeranjang']);
Route::get('add-to-cart/{id}', [TransactionController::class, 'addtocart']);
Route::post('update-cart', [TransactionController::class, 'updateCart']);
Route::post('update-quantity', [TransactionController::class, 'updateQuantity']);
Route::get('delete-cart/{id}', [TransactionController::class, 'deleteCart']);
Route::get('checkout', [TransactionController::class, 'checkout']);
Route::post('/do-checkout', [TransactionController::class, 'docheckout']);
Route::get('/calback', [TransactionController::class, 'calback']);
Route::get('bayar/{id}', [TransactionController::class, 'bayar']);
Route::get('bayar-qr/{id}', [TransactionController::class, 'bayarQr']);
Route::get('bayar-cod/{id}', [TransactionController::class, 'bayarCod']);
Route::post('/do-bayar', [TransactionController::class, 'dobayar']);
Route::get('histori-transaksi', [TransactionController::class, 'historiTransaksi']);
Route::get('terima-pesanan/{id}', [TransactionController::class, 'terimaPesanan']);
Route::get('batalkan-pesanan/{id}', [TransactionController::class, 'batalkanPesanan']);
Route::post('do-batalkan-pesanan', [TransactionController::class, 'doBatalkanPesanan']);
Route::get('retur-pesanan/{id}', [TransactionController::class, 'returPesanan']);
Route::post('do-retur-pesanan', [TransactionController::class, 'doReturPesanan']);
Route::get('get-kurir', [TransactionController::class, 'getKurir']);
Route::get('ulas-produk/{id}', [TransactionController::class, 'ulasProduk']);
Route::post('do-add-review/{id}', [TransactionController::class, 'doAddReview']);


// AUTH USER
Route::get('/login-user', [AuthController::class, 'login']);
Route::post('/do-login-user', [AuthController::class, 'doLogin']);
Route::get('/register-user', [AuthController::class, 'register']);
Route::post('/do-register-user', [AuthController::class, 'doRegister']);
Route::get('check-email', [AuthController::class, 'checkEmail']);
Route::post('do-check-email', [AuthController::class, 'doCheckEmail']);
Route::get('forgot-password/{id}', [AuthController::class, 'forgotPassword']);
Route::post('do-forgot-password', [AuthController::class, 'doForgotPassword']);
Route::get('logout-user', [AuthController::class, 'logout']);

Route::get('logout', [LoginController::class, 'logout']);
// Rules Before Login
Route::middleware(['authcheck'])->group(function() {
    Route::get('/login', [LoginController::class, 'index']);
    Route::post('/login/dologin', [LoginController::class, 'doLogin']);

    Route::get('/register', [LoginController::class, 'register']);
    Route::post('/do-register', [LoginController::class, 'doRegister']);
});

// Rules After Login
Route::middleware(['authlogedin'])->group(function(){
    Route::get('/dashboard', [HomeController::class, 'index']);
    Route::get('/laporan-keuangan', [HomeController::class, 'laporanKeuangan']);
    Route::get('/laporan', [HomeController::class, 'laporan']);
    Route::get('/laporan-produk', [HomeController::class, 'laporanProduk']);
    Route::get('/laporan-penjualan', [HomeController::class, 'laporanPenjualan']);
    Route::get('/chat', [HomeController::class, 'getChat']);
    Route::post('/do-add-chat', [HomeController::class, 'doAddChat']);

    // PETUGAS
    Route::get('/user', [UserController::class, 'index']);
    Route::get('/add-user', [UserController::class, 'create']);
    Route::post('/do-add-user', [UserController::class, 'store']);
    Route::get('/edit-user/{id}', [UserController::class, 'show']);
    Route::post('/do-update-user/{id}', [UserController::class, 'update']);
    Route::get('/delete-user/{id}', [UserController::class, 'destroy']);

    // Pelanggan
    Route::get('/pelanggan', [PelangganController::class, 'index']);
    Route::get('/add-pelanggan', [PelangganController::class, 'create']);
    Route::post('/do-add-pelanggan', [PelangganController::class, 'store']);
    Route::get('/edit-pelanggan/{id}', [PelangganController::class, 'show']);
    Route::post('/do-update-pelanggan/{id}', [PelangganController::class, 'update']);
    Route::get('/delete-pelanggan/{id}', [PelangganController::class, 'destroy']);

    // Kategori
    Route::get('/kategori', [KategoriController::class, 'index']);
    Route::get('/add-kategori', [KategoriController::class, 'create']);
    Route::post('/do-add-kategori', [KategoriController::class, 'store']);
    Route::get('/edit-kategori/{id}', [KategoriController::class, 'show']);
    Route::post('/do-update-kategori/{id}', [KategoriController::class, 'update']);
    Route::get('/delete-kategori/{id}', [KategoriController::class, 'destroy']);

    // Botol
    Route::get('/botol', [BotolController::class, 'index']);
    Route::get('/add-botol', [BotolController::class, 'create']);
    Route::post('/do-add-botol', [BotolController::class, 'store']);
    Route::get('/edit-botol/{id}', [BotolController::class, 'show']);
    Route::post('/do-update-botol/{id}', [BotolController::class, 'update']);
    Route::get('/delete-botol/{id}', [BotolController::class, 'destroy']);

    // Toko
    Route::get('/toko', [TokoController::class, 'index']);
    Route::get('/add-toko', [TokoController::class, 'create']);
    Route::post('/do-add-toko', [TokoController::class, 'store']);
    Route::get('/edit-toko/{id}', [TokoController::class, 'show']);
    Route::post('/do-update-toko/{id}', [TokoController::class, 'update']);
    Route::get('/delete-toko/{id}', [TokoController::class, 'destroy']);

    // Banner
    Route::get('/banner', [BannerController::class, 'index']);
    Route::get('/add-banner', [BannerController::class, 'create']);
    Route::post('/do-add-banner', [BannerController::class, 'store']);
    Route::get('/edit-banner/{id}', [BannerController::class, 'show']);
    Route::post('/do-update-banner/{id}', [BannerController::class, 'update']);
    Route::get('/delete-banner/{id}', [BannerController::class, 'destroy']);

	// Produk
	Route::get('/produk', [ProdukController::class, 'index']);
    Route::get('/add-produk', [ProdukController::class, 'create']);
    Route::post('/do-add-produk', [ProdukController::class, 'store']);
    Route::get('/edit-produk/{id}', [ProdukController::class, 'show']);
    Route::post('/do-update-produk/{id}', [ProdukController::class, 'update']);
    Route::get('/delete-produk/{id}', [ProdukController::class, 'destroy']);
    Route::get('/gambar-produk/{id}', [ProdukController::class, 'productImageIndex']);
    Route::post('/do-upload-images/{id}', [ProdukController::class, 'doUploadProductImages']);
    Route::get('/set-as-thumbnail/{id}/{id_produk}', [ProdukController::class, 'setAsThumbnail']);
    Route::get('/delete-products-images/{id}/{id_produk}', [ProdukController::class, 'destroyImage']);

    // Galeri
	Route::get('/galeri', [GaleriController::class, 'index']);
    Route::get('/add-galeri', [GaleriController::class, 'create']);
    Route::post('/do-add-galeri', [GaleriController::class, 'store']);
    Route::get('/edit-galeri/{id}', [GaleriController::class, 'show']);
    Route::post('/do-update-galeri/{id}', [GaleriController::class, 'update']);
    Route::get('/delete-galeri/{id}', [GaleriController::class, 'destroy']);

    // Transaksi
    Route::get('/transaksi', [TransaksiController::class, 'index']);
    Route::get('/detail-transaksi/{id}', [TransaksiController::class, 'detail']);
    Route::post('/update-transaksi/{id}', [TransaksiController::class, 'updateTransaksi']);
    Route::post('/update-transaksi-retur/{id}', [TransaksiController::class, 'updateTransaksiRetur']);

    // DATA SCIENCE & ANALYTICS (ADMIN)
    Route::get('/data-science', [DataScienceController::class, 'index']);
    Route::get('/data-science/segmentation', [DataScienceController::class, 'segmentation']);
    Route::get('/data-science/forecasting', [DataScienceController::class, 'forecasting']);
    Route::get('/data-science/sentiment', [DataScienceController::class, 'sentiment']);
    Route::get('/data-science/recommender', [DataScienceController::class, 'recommender']);

});

// Public AI Recommendation API
Route::get('/api/data-science/recommendations/{id}', [DataScienceController::class, 'apiRecommendations']);

// Static Footer Pages
Route::get('/tentang-kami', function() { return view('frontend.pages.tentang-kami'); });
Route::get('/hubungi-kami', function() { return view('frontend.pages.hubungi-kami'); });
Route::get('/garansi', function() { return view('frontend.pages.garansi'); });
Route::get('/kebijakan-pengembalian', function() { return view('frontend.pages.kebijakan-pengembalian'); });
Route::get('/faq', function() { return view('frontend.pages.faq'); });
Route::get('/lacak-pengiriman', function() { return view('frontend.pages.lacak-pengiriman'); });
Route::get('/keuntungan-member', function() { return view('frontend.pages.keuntungan-member'); });
