<?php

namespace App\Http\Controllers;

use App\barang;
use DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class BarangController extends Controller
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
            $barang = Barang::all();
            $Persediaan = DB::select('SELECT sum(stok * hargaBeli) as harga FROM barang');
            $nilaiPersediaan = 0;
            foreach($Persediaan as $key){
                $nilaiPersediaan += $key->harga;
            }
            $data['nilaiPersediaan'] = $nilaiPersediaan;
            $data['barang'] = $barang;
            return view('barang.index', $data);
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
            $data['action'] = 'barang.store';
            return view('barang.form', $data);
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
        $barang = new Barang();
        $barang->kode = $request->kode;
        $barang->nama = $request->nama;
        $barang->stok = $request->stok;
        $barang->hargaBeli = $request->hargaBeli;
        $barang->hargaJual = $request->hargaJual;
        $barang->HPP = $request->hargaBeli;
        $barang->save();

        return redirect('/barang')->with((['success' => 'Data Berhasil ditambah']));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function show(barang $barang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function edit(barang $barang)
    {
        if (!Session::get('login')) {
            return redirect('login');
        } else {
            $barang = Barang::find($barang->barangId);
            $data['barang'] = $barang;
            $data['action'] = 'barang/update';
            return view('barang.form', $data);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, barang $barang)
    {
        $barang = Barang::find($request->barangId);
        $barang->barangId = $request->barangId;
        $barang->kode = $request->kode;
        $barang->nama = $request->nama;
        $barang->stok = $request->stok;
        $barang->hargaBeli = $request->hargaBeli;
        $barang->hargaJual = $request->hargaJual;
        $barang->save();
        return redirect('/barang')->with((['success' => 'Data berhasil diupdate']));
    }
    public function delete($id)
    {
        if (!Session::get('login')) {
            return view('login.login');
        } else {
            try {
                $barang = Barang::find($id);
                $barang->delete();
                return redirect('/barang')->with((['success' => 'Data ' . $barang->nama . ' Berhasil dihapus']));
            } catch (QueryException $ex) {
                return redirect('/barang')->with((['error' => 'Data ' . $barang->nama . ' Gagal dihapus karena masih digunakan pada Tabel Lain']));
            }
        }
    }
}
