<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Religion;
use App\Models\City;
use App\Models\Province;
use App\Models\Matching;
use App\Models\Chat;
use App\Models\DetailChat;
use App\Models\Laporan;
use DB;

class ApiController extends Controller
{

    public function register(Request $request)
    {
        
        $checkEmail = User::where('email', $request->email)->first();
        if (!empty($checkEmail)) {
           return returnAPI(201, 'Email telah terdaftar.!');
        }

        // Insert user first
        $user = new User;
        $user->name     = $request->name;
        $user->phone_number    = $request->phone_number;
        $user->email    = $request->email;
        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->role = 'user';
        $user->save();
        return returnAPI(200, 'Success', $user);
    }

    public function login(Request $request)
    {
        $checkUser = User::where('username', $request->username)->first();
        if($checkUser->status == 2){
            return returnAPI(201, 'Akun kamu disuspend tidak bisa login.!');
        }
        if (!empty($checkUser)) {
            if(Hash::check($request->password, $checkUser->password)){
                return returnAPI(200, 'Success', $checkUser);
            }else{
                return returnAPI(201, 'Password salah.!');
            }
        }else{
            return returnAPI(201, 'Email tidak terdaftar.!');
        }
    }

    public function updateProfile(Request $request)
    {
        $data = User::where('id', $request->user_id)->first();
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone_number = $request->phone_number;
        $data->age = $request->age;
        $data->birtday = $request->birtday;
        $data->gender = $request->gender;
        $data->address = $request->address;
        $data->religion_id = $request->religion_id;
        $data->province_id = $request->province_id;
        $data->city_id = $request->city_id;
        $data->description = $request->description;

        if($request->file('image')){
            $file       = $request->file('image');
            $extention  = $file->extension();
            $file_resep = date('YmdHis').'.'.$extention;
            $file->move(public_path('upload/image'), $file_resep);

            $data->image   = $file_resep;
        }
        $data->name = $request->name;
        $data->role = 'user';
        $data->save();

        return returnAPI(200, 'Success!', $data);
        
    }

    public function forgotPassword(Request $request)
    {
        $data = User::where('id', $request->user_id)->first();
        $data->password = Hash::make($request->password);
        $data->save();

        return returnAPI(200, 'Success!', $data);
        
    }

    /*=============================== END AUTH ==============================*/

    public function getReligion(Request $request)
    {   
        $data = Religion::get();
        return returnAPI(200, 'Success', $data);
    }

    public function getProvince(Request $request)
    {   
        $data = Province::get()->all();
        return returnAPI(200, 'Success', $data);
    }

    public function getCity(Request $request)
    {   
        $data = City::get();
        return returnAPI(200, 'Success', $data);
    }

    public function getUser(Request $request)
    {   
        $data = User::join('religion','religion.id','religion_id')
            ->join('provinces','provinces.id','province_id')
            ->join('cities','cities.id','city_id')
            ->select('users.*','religion.religion','prov_name','city_name')
            ->where('users.id', '!=', $request->user_id)->where('role', 'user')->inRandomOrder()->get();
        foreach ($data as $key => $value) {
            $foto = asset('upload/image/'.$value->image);
            $data[$key]->foto_path = $foto;
            if($value->gender == 'L'){
                $data[$key]->gender = 'Laki laki';
            }else{
                $data[$key]->gender = 'Perempuan';
            }
        }
        return returnAPI(200, 'Success', $data);
    }

    public function matching(Request $request)
    {
        $cek = Matching::where('user_id', $request->user_id)->where('other_user_id', $request->other_user_id)->first();
        if(!empty($cek)){
            return returnAPI(201, 'Kamu Sudah melakukan matching dengan dia');

        }

        $us = new Matching;
        $us->user_id = $request->user_id;
        $us->other_user_id = $request->other_user_id;
        $us->status = $request->status;
        $us->save();

        return returnAPI(200, 'Success!');
        
    }

    public function getMatching(Request $request)
    {   
        DB::enableQueryLog();
        $data = Matching::join('users','users.id','other_user_id')
            ->select('matching.*','users.name','users.image','users.age','users.address')
            ->where('matching.user_id', $request->user_id)
            ->where('matching.status', 1)
            ->get();
        $query = DB::getQueryLog();

        foreach ($data as $key => $value) {
            $foto = asset('upload/image/'.$value->image);
            $data[$key]->foto_path = $foto;
        }

        return returnAPI(200, 'Success!', $data);
        
    }

    public function getMyListChat(Request $request)
    {
        $data = Chat::where('receiver_id', $request->user_id)->get();
        return returnAPI(200, 'Success!', $data);
    }

    public function sendChat(Request $request)
    {   
        // sender_id = user_login
        // receiver_id = org yg dilike

        $cek = Chat::where('id', $request->id)->first(); // pengecekan chat pertama kali
        if(empty($cek)){

            $us = new Chat;
            $us->sender_id    = $request->sender_id;
            $us->receiver_id  = $request->receiver_id;
            $us->save();

            $getData = Chat::where('id', $us->id)->first();

            $as = new DetailChat;
            $as->chat_id = $us->id;

            if($getData->sender_id == $request->sender_id){
                $as->chat_sender = $request->chat;
            }else{
                $as->chat_receiver = $request->chat;
            }
            $as->save();

        }else{
            $as = new DetailChat;
            $as->chat_id = $cek->id;

            if($cek->sender_id == $request->sender_id){
                $as->chat_sender = $request->chat;
            }else{
                $as->chat_receiver = $request->chat;
            }
            $as->save();
        }
        
        return returnAPI(200, 'Success!');
        
    }

    public function getChat(Request $request)
    {   
        $data = DetailChat::where('chat_id', $request->chat_id)->get();
        return returnAPI(200, 'Success!', $data);
        
    }

    public function getLaporan(Request $request)
    {   
        $data = Laporan::get();
        return returnAPI(200, 'Success!', $data);
        
    }

    public function addLaporan(Request $request)
    {   
        $data = new Laporan;
        $data->user_id = $request->user_id;
        $data->other_user_id = $request->other_user_id;
        $data->laporan = $request->laporan;
        $data->save();

        return returnAPI(200, 'Success!', $data);
        
    }

    public function suspend(Request $request)
    {   
        $data = User::where('id', $request->user_id)->first();
        $data->status = 2;
        $data->save();

        return returnAPI(200, 'Success!', $data);
        
    }
}
