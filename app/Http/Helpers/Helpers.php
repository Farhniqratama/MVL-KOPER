<?php
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Kategori;
use App\Models\Cart;
use App\Models\Chat;
use App\Models\DetailChat;
use App\Models\Toko;
use Carbon\Carbon;

if (! function_exists('debugCode')) {
    function debugCode($r=array(),$f=TRUE)
    {
        echo "<pre>";
        print_r($r);
        echo "</pre>";

        if($f==TRUE) 
            die;
    }
}

function selected($par1, $par2)
{
    return ($par1 == $par2)?"selected":'';
}

function hari($tgl)
{
    Carbon::setLocale('id');
    $dayOfWeek = Carbon::parse($tgl)->translatedFormat('l');

    return $dayOfWeek;
}

function selected_in_array($par1, $par2 = [])
{
    if (in_array($par1, $par2)) {
        return 'selected';
    }
}


function calculate_days($date1, $date2)
{
    $diff   = abs(strtotime($date2) - strtotime($date1));
    $years  = floor($diff / (365*60*60*24));
    $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
    $days   = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
    return $days;
}

function html_star($star = 0)
{
    if ($star == 5) {
        $html = '
            <i class="fa fa-star" style="color:#f2b01e"></i>
            <i class="fa fa-star" style="color:#f2b01e"></i>
            <i class="fa fa-star" style="color:#f2b01e"></i>
            <i class="fa fa-star" style="color:#f2b01e"></i>
            <i class="fa fa-star" style="color:#f2b01e"></i>
        ';
    }elseif($star >= 4 and $star < 5){
        $html = '
            <i class="fa fa-star" style="color:#f2b01e"></i>
            <i class="fa fa-star" style="color:#f2b01e"></i>
            <i class="fa fa-star" style="color:#f2b01e"></i>
            <i class="fa fa-star" style="color:#f2b01e"></i>
            <i class="fa fa-star" style="color:#afafaf"></i>
        ';
    }elseif($star >= 3 and $star < 4){
        $html = '
            <i class="fa fa-star" style="color:#f2b01e"></i>
            <i class="fa fa-star" style="color:#f2b01e"></i>
            <i class="fa fa-star" style="color:#f2b01e"></i>
            <i class="fa fa-star" style="color:#afafaf"></i>
            <i class="fa fa-star" style="color:#afafaf"></i>
        ';
    }elseif($star >=2 and $star < 3){
        $html = '
            <i class="fa fa-star" style="color:#f2b01e"></i>
            <i class="fa fa-star" style="color:#f2b01e"></i>
            <i class="fa fa-star" style="color:#afafaf"></i>
            <i class="fa fa-star" style="color:#afafaf"></i>
            <i class="fa fa-star" style="color:#afafaf"></i>
        ';
    }elseif($star >= 1 and $star <2){
        $html = '
            <i class="fa fa-star" style="color:#f2b01e"></i>
            <i class="fa fa-star" style="color:#afafaf"></i>
            <i class="fa fa-star" style="color:#afafaf"></i>
            <i class="fa fa-star" style="color:#afafaf"></i>
            <i class="fa fa-star" style="color:#afafaf"></i>
        ';
    }else{
        $html = '
            <i class="fa fa-star" style="color:#afafaf"></i>
            <i class="fa fa-star" style="color:#afafaf"></i>
            <i class="fa fa-star" style="color:#afafaf"></i>
            <i class="fa fa-star" style="color:#afafaf"></i>
            <i class="fa fa-star" style="color:#afafaf"></i>
        ';
    }
    return $html;
}

function status_peminjaman($key=0, $is_html=0)
{
    $status_kata  = ['Request', 'Dipinjam', 'Dikembalikan', 'Selesai', 'Batal'];
    $status_color = ['#e67e22', '#3498db', '#2ecc71', '#3f7a00', '#c0392b'];

    if ($is_html == 0) {
        return $status_kata[$key];
    }else{
        return '<span style="color:'.$status_color[$key].'" class="text-bold">'.$status_kata[$key].'</span>';
    }
}

function return_json($code=200, $status="Success", $message="", $data=[])
{
    $return = [
        'code'    => $code,
        'status'  => $status,
        'message' => $message,
        'data'    => $data
    ];

    return response()->json($return);
}

function get_user_foto()
{
    $user    = request()->session()->get('auth_user');
    $user_id = $user['id'];

    $data = User::where('id', $user_id)->first();
    $foto = asset('adminlte/dist/img/user2-160x160.jpg');
    if ($data['foto'] != "") {
        $foto = asset('assets/foto/'.$data->foto);
    }
    return $foto;
}

function getKategori()
{
    $categoryData = Kategori::get();
    return $categoryData;
}

function getToko()
{
    $dataToko = Toko::get();
    return $dataToko;
}

function getCart($user_id)
{
    $dataCart = Cart::join('produk as p','p.id','=','cart.produk_id')->join('gambar_produk','gambar_produk.produk_id','p.id')->select('cart.*','p.nama_produk','p.harga','p.deskripsi','gambar_produk.gambar')->where('user_id', $user_id)->where('is_thumbnails',1)->get()->all();
    return $dataCart;
}

function getDataChat($user_id)
{
    $dataProduk = $data = Chat::join('detail_chat as dd', 'dd.chat_id','chat.id')->select('dd.*')->where('sender_id', $user_id)->get();
    return $dataProduk;
}

function tgl_indo($tanggal){
    $bulan = array (
        1 =>   'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    );
    $pecahkan = explode('-', $tanggal);
    
    // variabel pecahkan 0 = tanggal
    // variabel pecahkan 1 = bulan
    // variabel pecahkan 2 = tahun
 
    return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
}

function bulan($bulan){
    Switch ($bulan){
        case 1 : $bulan="Januari";
            Break;
        case 2 : $bulan="Februari";
            Break;
        case 3 : $bulan="Maret";
            Break;
        case 4 : $bulan="April";
            Break;
        case 5 : $bulan="Mei";
            Break;
        case 6 : $bulan="Juni";
            Break;
        case 7 : $bulan="Juli";
            Break;
        case 8 : $bulan="Agustus";
            Break;
        case 9 : $bulan="September";
            Break;
        case 10 : $bulan="Oktober";
            Break;
        case 11 : $bulan="November";
            Break;
        case 12 : $bulan="Desember";
            Break;
        }
    return $bulan;
}

function hari_ini($hari){
 
    switch($hari){
        case 'Sunday':
            $hari_ini = "Minggu";
        break;
 
        case 'Monday':         
            $hari_ini = "Senin";
        break;
 
        case 'Tuesday':
            $hari_ini = "Selasa";
        break;
 
        case 'Wednesday':
            $hari_ini = "Rabu";
        break;
 
        case 'Thursday':
            $hari_ini = "Kamis";
        break;
 
        case 'Friday':
            $hari_ini = "Jumat";
        break;
 
        case 'Saturday':
            $hari_ini = "Sabtu";
        break;
    }
 
    return $hari_ini;
 
}