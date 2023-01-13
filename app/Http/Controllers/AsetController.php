<?php

namespace App\Http\Controllers;

use App\Aset;
use App\akun;
use DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class AsetController extends Controller
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
            $akunSaldo = DB::table('saldoperiode')
                ->join('akun', 'akun.akunid', '=', 'saldoperiode.akunid')
                ->join('periode', 'periode.periodeid', '=', 'saldoperiode.periodeid')
                ->select('saldoperiode.*', 'akun.*', 'periode.tahun')
                ->orderBy('akun.akunid')
                ->where('periode.aktif', '=', 1)
                ->get();
            $data['akun'] = $akunSaldo;
            $totalAset = DB::select("SELECT sum(jumlah * harga) as total FROM aset");
            $nilaiAset = 0;
            $periode = DB::select("SELECT tahun from periode where aktif = 1");
            $tahun = 0;
            foreach($periode as $key){
                $tahun = $key->tahun;
            }
            foreach($totalAset as $key){
                $nilaiAset += $key->total;
            }
            $penyusutanAsetAktif = DB::select("SELECT FLOOR(sum(TIMESTAMPDIFF(MONTH, tanggal,'$tahun-01-01')*penyusutan)/1000)*1000 as total FROM aset where tanggal + INTERVAL aset.masaManfaat MONTH > '$tahun-01-01'");
            $penyusutanPerBulan = DB::select("SELECT sum(penyusutan) as total FROM aset where tanggal + INTERVAL aset.masaManfaat MONTH > '$tahun-01-01'");
            $nilaiPenyusutanPerBulan = 0;
            foreach($penyusutanPerBulan as $key){
                $nilaiPenyusutanPerBulan += $key->total;
            }
            $nilaiPenyusutanAsetAktif = 0;
            foreach($penyusutanAsetAktif as $key){
                $nilaiPenyusutanAsetAktif += $key->total;
            }
            $data['nilaiAset'] = $nilaiAset;
            $data['penyusutanAsetAktif'] = $nilaiPenyusutanAsetAktif;
            $data['penyusutanPerBulan'] = $nilaiPenyusutanPerBulan;
            $aset = Aset::all();
            $data['aset'] = $aset;
            return view('aset.index', $data);
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
            $data['action'] = 'aset.store';
            $data['tahun'] = DB::table('periode')->where('aktif', 1)->max('tahun');
            return view('aset.form', $data);
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
        $aset = new Aset();
        $aset->nama = $request->nama;
        $aset->tanggal = $request->tanggal;
        $aset->jumlah = $request->jumlah;
        $aset->harga = $request->harga;
        $aset->masaManfaat = $request->masaManfaat;
        $aset->penyusutan = $request->harga / $request->masaManfaat;
        $aset->save();



        return redirect('/aset')->with((['success' => 'Data Berhasil ditambah']));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Aset  $aset
     * @return \Illuminate\Http\Response
     */
    public function show(Aset $aset)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Aset  $aset
     * @return \Illuminate\Http\Response
     */
    public function edit(Aset $aset)
    {
        if (!Session::get('login')) {
            return redirect('login');
        } else {
            $aset = Aset::find($aset->asetId);
            $data['aset'] = $aset;
            $data['action'] = 'aset/update';
            return view('aset.form', $data);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Aset  $aset
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Aset $aset)
    {
        $aset = Aset::find($request->asetId);
        $aset->asetId = $request->asetId;
        $aset->nama = $request->nama;
        $aset->tanggal = $request->tanggal;
        $aset->jumlah = $request->jumlah;
        $aset->harga = $request->harga;
        $aset->masaManfaat = $request->masaManfaat;
        $aset->penyusutan = $request->harga / $request->masaManfaat;
        $aset->save();
        return redirect('/aset')->with((['success' => 'Data berhasil diupdate']));
    }
    public function delete($id)
    {
        if (!Session::get('login')) {

            return view('login.login');
        } else {
            try {
                $aset = Aset::find($id);
                $aset->delete();
                return redirect('/aset')->with((['success' => 'Data ' . $aset->nama . ' Berhasil dihapus']));
            } catch (QueryException $ex) {
                return redirect('/aset')->with((['error' => 'Data ' . $aset->nama . ' Gagal dihapus karena masih digunakan pada Tabel Lain']));
            }
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Aset  $aset
     * @return \Illuminate\Http\Response
     */
    public function destroy(Aset $aset)
    {
        //
    }
}
