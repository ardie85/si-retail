<?php

namespace App\Http\Controllers;

use App\karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Session::get('login')) {
            return view('login.login');
        } else {
            $karyawan = DB::table('pengguna')
                ->select('*')
                ->where('pengguna.jenis', '=', 'Karyawan')
                ->get();
            $data['karyawan'] = $karyawan;
            return view('karyawan.index', $data);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Session::get('login')) {
            return redirect('login');
        } else {
            $data['action'] = 'karyawan.store';
            return view('karyawan.form', $data);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $karyawan = new Karyawan();
        $karyawan->nama = $request->nama;
        $karyawan->username = $request->username;
        $karyawan->password = $request->password;
        $karyawan->alamat = $request->alamat;
        $karyawan->nomorTelp = $request->nomorTelp;
        $karyawan->jenis = "Karyawan";
        $karyawan->save();

        return redirect('/karyawan')->with((['success' => 'Data Berhasil ditambah']));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Karyawan  $karyawan
     * @return \Illuminate\Http\Response
     */
    public function show(Karyawan $karyawan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Karyawan  $karyawan
     * @return \Illuminate\Http\Response
     */
    public function edit(Karyawan $karyawan)
    {
        if (!Session::get('login')) {
            return redirect('login');
        } else {
            $karyawan = Karyawan::find($karyawan->penggunaId);
            $data['karyawan'] = $karyawan;
            $data['action'] = 'karyawan/update';
            return view('karyawan.form', $data);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Karyawan  $karyawan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Karyawan $karyawan)
    {
        $karyawan = Karyawan::find($request->penggunaId);
        $karyawan->penggunaId = $request->penggunaId;
        $karyawan->nama = $request->nama;
        $karyawan->username = $request->username;
        $karyawan->password = $request->password;
        $karyawan->alamat = $request->alamat;
        $karyawan->nomorTelp = $request->nomorTelp;
        $karyawan->jenis = "Karyawan";
        $karyawan->save();
        return redirect('/karyawan')->with((['success' => 'Data berhasil diupdate']));
    }
    public function delete($id)
    {
        if (!Session::get('login')) {
            return view('login.login');
        } else {
            try {
                $karyawan = Karyawan::find($id);
                $karyawan->delete();
                return redirect('/karyawan')->with((['success' => 'Data ' . $karyawan->nama . ' Berhasil dihapus']));
            } catch (QueryException $ex) {
                return redirect('/karyawan')->with((['error' => 'Data ' . $karyawan->nama . ' Gagal dihapus karena masih digunakan pada Tabel Lain']));
            }
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Karyawan  $karyawan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Karyawan $karyawan)
    {
        //
    }
}
