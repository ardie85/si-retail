<?php

namespace App\Http\Controllers;

use App\pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PelangganController extends Controller
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
            $pelanggan = Pelanggan::all();
            $data['pelanggan'] = $pelanggan;
            return view('pelanggan.index', $data);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!\Session::get('login')) {
            return redirect('login');
        } else {
            $data['action'] = 'pelanggan.store';
            return view('pelanggan.form', $data);
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
        $pelanggan = new Pelanggan();
        $pelanggan->nama = $request->nama;
        $pelanggan->alamat = $request->alamat;
        $pelanggan->nomorTelp = $request->nomorTelp;
        $pelanggan->save();

        return redirect('/pelanggan')->with((['success' => 'Data Berhasil ditambah']));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pelanggan  $pelanggan
     * @return \Illuminate\Http\Response
     */
    public function show(Pelanggan $pelanggan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pelanggan  $pelanggan
     * @return \Illuminate\Http\Response
     */
    public function edit(Pelanggan $pelanggan)
    {
        if (!Session::get('login')) {
            return redirect('login');
        } else {
            $pelanggan = Pelanggan::find($pelanggan->pelangganId);
            $data['pelanggan'] = $pelanggan;
            $data['action'] = 'pelanggan/update';
            return view('pelanggan.form', $data);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pelanggan  $pelanggan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pelanggan $pelanggan)
    {
        $pelanggan = Pelanggan::find($request->pelangganId);
        $pelanggan->pelangganId = $request->pelangganId;
        $pelanggan->nama = $request->nama;
        $pelanggan->alamat = $request->alamat;
        $pelanggan->nomorTelp = $request->nomorTelp;
        $pelanggan->save();
        return redirect('/pelanggan')->with((['success' => 'Data berhasil diupdate']));
    }
    public function delete($id)
    {
        if (!Session::get('login')) {
            return view('login.login');
        } else {
            try {
                $pelanggan = Pelanggan::find($id);
                $pelanggan->delete();
                return redirect('/pelanggan')->with((['success' => 'Data ' . $pelanggan->nama . ' Berhasil dihapus']));
            } catch (QueryException $ex) {
                return redirect('/pelanggan')->with((['error' => 'Data ' . $pelanggan->nama . ' Gagal dihapus karena masih digunakan pada Tabel Lain']));
            }
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pelanggan  $pelanggan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pelanggan $pelanggan)
    {
        //
    }
}
