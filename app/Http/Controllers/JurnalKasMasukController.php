<?php

namespace App\Http\Controllers;

use App\JurnalKasMasuk;
use App\Periode;
use DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class JurnalKasMasukController extends Controller
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
            $periode = Periode::all();
            $data['jurnalKasMasuk'] = null;
            $data['periode'] = $periode;
            return view('jurnal_kas_masuk.index', $data);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\JurnalKasMasuk  $jurnalKasMasuk
     * @return \Illuminate\Http\Response
     */
    public function show(JurnalKasMasuk $jurnalKasMasuk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\JurnalKasMasuk  $jurnalKasMasuk
     * @return \Illuminate\Http\Response
     */
    public function edit(JurnalKasMasuk $jurnalKasMasuk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\JurnalKasMasuk  $jurnalKasMasuk
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, JurnalKasMasuk $jurnalKasMasuk)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\JurnalKasMasuk  $jurnalKasMasuk
     * @return \Illuminate\Http\Response
     */
    public function destroy(JurnalKasMasuk $jurnalKasMasuk)
    {
        //
    }

    public function search(Request $request)
    {
        if (!Session::get('login')) {
            return view('login.login');
        } else {
            if($request->bulan == "13"){
                $jurnalKasMasuk = DB::select("SELECT tanggal, faktur, debitKas, debitDiskon, kreditModal, debitHargaPokokPenjualan, kreditPenjualan, kreditPiutangUsaha, kreditPersediaan from jurnalkasmasuk where tanggal Like '$request->tahun-%-%'");
                $periode = Periode::all();
                $data['tahun'] = $request->tahun;
                $data['jurnalKasMasuk'] = $jurnalKasMasuk;
                $data['bulan'] = "Jan - Des";
                $data['periode'] = $periode;
                if($request->action == "Print"){
                    return view('jurnal_kas_masuk.print', $data);
                }else{
                    return view('jurnal_kas_masuk.index', $data);
                }
            }else{
            $jurnalKasMasuk = DB::select("SELECT tanggal, faktur, debitKas, debitDiskon, kreditModal, debitHargaPokokPenjualan, kreditPenjualan, kreditPiutangUsaha, kreditPersediaan from jurnalkasmasuk where tanggal Like '$request->tahun-$request->bulan-%'");
            $periode = Periode::all();
            $data['tahun'] = $request->tahun;
            if ($request->bulan == "01") {
                $data['bulan'] = "Januari";
            } elseif ($request->bulan == "02") {
                $data['bulan'] = "Februari";
            } elseif ($request->bulan == "03") {
                $data['bulan'] = "Maret";
            } elseif ($request->bulan == "04") {
                $data['bulan'] = "April";
            } elseif ($request->bulan == "05") {
                $data['bulan'] = "Mei";
            } elseif ($request->bulan == "06") {
                $data['bulan'] = "Juni";
            } elseif ($request->bulan == "07") {
                $data['bulan'] = "Juli";
            } elseif ($request->bulan == "08") {
                $data['bulan'] = "Agustus";
            } elseif ($request->bulan == "09") {
                $data['bulan'] = "September";
            } elseif ($request->bulan == "10") {
                $data['bulan'] = "Oktober";
            } elseif ($request->bulan == "11") {
                $data['bulan'] = "November";
            } else {
                $data['bulan'] = "Desember";
            }
            $data['jurnalKasMasuk'] = $jurnalKasMasuk;
            $data['periode'] = $periode;
            if($request->action == "Print"){
                return view('jurnal_kas_masuk.print', $data);
            }else{
                return view('jurnal_kas_masuk.index', $data);
            }
        }
        }
    }
}
