<?php

namespace App\Http\Controllers;

use App\JurnalKasKeluar;
use App\Periode;
use Illuminate\Support\Facades\Session;
use DB;
use Illuminate\Http\Request;

class JurnalKasKeluarController extends Controller
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
            $data['jurnalKasKeluar'] = null;
            $data['periode'] = $periode;
            return view('jurnal_kas_keluar.index', $data);
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
     * @param  \App\JurnalKasKeluar  $jurnalKasKeluar
     * @return \Illuminate\Http\Response
     */
    public function show(JurnalKasKeluar $jurnalKasKeluar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\JurnalKasKeluar  $jurnalKasKeluar
     * @return \Illuminate\Http\Response
     */
    public function edit(JurnalKasKeluar $jurnalKasKeluar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\JurnalKasKeluar  $jurnalKasKeluar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, JurnalKasKeluar $jurnalKasKeluar)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\JurnalKasKeluar  $jurnalKasKeluar
     * @return \Illuminate\Http\Response
     */
    public function destroy(JurnalKasKeluar $jurnalKasKeluar)
    {
        //
    }
    public function search(Request $request)
    {
        if (!Session::get('login')) {
            return view('login.login');
        } else {
            if ($request->bulan == "13") {
                $jurnalKasKeluar = DB::select("SELECT tanggal, faktur, debitPersediaan, debitHutangUsaha, kreditKas, debitBeban, debitReturPenjualan, kreditHargaPokokPenjualan from jurnalkaskeluar where tanggal Like '$request->tahun-%-%'");
                $periode = Periode::all();
                $data['tahun'] = $request->tahun;
                $data['bulan'] = "Jan - Des";
                $data['jurnalKasKeluar'] = $jurnalKasKeluar;
                $data['periode'] = $periode;
                if($request->action == "Print"){
                    return view('jurnal_kas_keluar.print', $data);
                }else{
                    return view('jurnal_kas_keluar.index', $data);
                }
            } else {
                $jurnalKasKeluar = DB::select("SELECT tanggal, faktur, debitPersediaan, debitHutangUsaha, kreditKas, debitBeban, debitReturPenjualan, kreditHargaPokokPenjualan from jurnalkaskeluar where tanggal Like '$request->tahun-$request->bulan-%'");
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
                $data['jurnalKasKeluar'] = $jurnalKasKeluar;
                $data['periode'] = $periode;
                if($request->action == "Print"){
                    return view('jurnal_kas_keluar.print', $data);
                }else{
                    return view('jurnal_kas_keluar.index', $data);
                }
            }
        }
    }
}
