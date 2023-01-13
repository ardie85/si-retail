<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Pengguna;

class LoginController extends Controller
{
    public function index()
    {
        // if (!Session::get('login')) {

            return view('login.login');
        // } else {
        //     return redirect('akun');
        // }
    }

    public function loginPost(Request $request)
    {
        $username = $request->username;
        $password = $request->password;

        $data = Pengguna::where('username', $username)->first();
        if ($data) {
            if ($data->password == $password) {
                Session::put('penggunaId', $data->penggunaId);
                Session::put('nama', $data->nama);
                Session::put('jenis', $data->jenis);
                Session::put('login', TRUE);
                return redirect('akun');
            } else {
                return redirect('login')->with('alert', 'Password Salah');
            }
        } else {
            return redirect('login')->with('alert', 'Username atau Password Salah');
        }
    }

    public function logout()
    {
        Session::flush();
        return redirect('login');
    }

    public function register()
    {
        return view('login.register');
    }

    public function registerPost(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required',
            'username' => 'required',
            'password' => 'required',
            'repassword' => 'required',
            'agreeTerms' => 'checked'
        ]);

        $data = User::where('username', $request->username)->first();
        if ($data) {
            return redirect('register')->with('alert', 'Username sudah terdaftar');
        } elseif ($request->password != $request->repassword) {
            return redirect('register')->with('alert', 'Password harus diisi sama');
        }else {

            $data =  new User();
            $data->nama = $request->nama;
            $data->username = $request->username;
            $data->password = $request->password;
            $data->save();
            return redirect('login')->with('alert-success', 'Kamu berhasil Register');
        }
    }
}
