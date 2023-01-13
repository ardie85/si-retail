<?php

namespace App\Http\Controllers;

use App\JurnalPembelian;
use App\Periode;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class JurnalPembelianController extends Controller
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
            $data['jurnalPembelian'] = null;
            $data['periode'] = $periode;
            return view('jurnal_pembelian.index', $data);
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
     * @param  \App\JurnalPembelian  $jurnalPembelian
     * @return \Illuminate\Http\Response
     */
    public function show(JurnalPembelian $jurnalPembelian)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\JurnalPembelian  $jurnalPembelian
     * @return \Illuminate\Http\Response
     */
    public function edit(JurnalPembelian $jurnalPembelian)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\JurnalPembelian  $jurnalPembelian
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, JurnalPembelian $jurnalPembelian)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\JurnalPembelian  $jurnalPembelian
     * @return \Illuminate\Http\Response
     */
    public function destroy(JurnalPembelian $jurnalPembelian)
    {
        //
    }
    public function search(Request $request)
    {
        if (!Session::get('login')) {
            return view('login.login');
        } else {
            if ($request->bulan == "13") {
                $jurnalPembelian = DB::select("SELECT jurnalPembelianTgl, faktur, keterangan, debitPersediaan, kreditHutang, kreditKas, debitKas, kreditPersediaan, debitHutang from jurnalpembelian where jurnalPembelianTgl Like '$request->tahun-%-%'");
                $periode = Periode::all();
                $data['tahun'] = $request->tahun;
                $data['bulan'] = "Jan - Des";
                $data['jurnalPembelian'] = $jurnalPembelian;
                $data['periode'] = $periode;
                if($request->action == "Print"){
                    return view('jurnal_pembelian.print', $data);
                }else{
                    return view('jurnal_pembelian.index', $data);
                }
            } else {
                $jurnalPembelian = DB::select("SELECT jurnalPembelianTgl, faktur, keterangan,debitPersediaan, kreditHutang, kreditKas, debitKas, kreditPersediaan, debitHutang from jurnalpembelian where jurnalPembelianTgl Like '$request->tahun-$request->bulan-%'");
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
                $data['jurnalPembelian'] = $jurnalPembelian;
                $data['periode'] = $periode;
                if($request->action == "Print"){
                    return view('jurnal_pembelian.print', $data);
                }else{
                    return view('jurnal_pembelian.index', $data);
                }
            }
        }
    }
}
