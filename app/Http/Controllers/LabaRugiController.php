<?php

namespace App\Http\Controllers;

use App\Periode;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LabaRugiController extends Controller
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
            $data['pendapatan'] = null;
            $data['beban'] = null;
            $data['periode'] = $periode;
            return view('laporan_keuangan.laba_rugi', $data);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function search(Request $request)
    {
        if (!Session::get('login')) {
            return view('login.login');
        } else {
            if ($request->bulan == "13") {
                $pendapatan = DB::select("SELECT a.nama as akun, sum(j.debit) as pendapatanKredit, sum(j.kredit) as pendapatanDebit from jurnalumum as j, akun as a where tanggal LIKE '$request->tahun-%-%' AND akun LIKE '4%' AND akun <> '4102' AND j.akun = a.akunId GROUP BY j.akun");
                $beban = DB::select("SELECT a.nama as akun, sum(j.debit) as bebanKredit, sum(j.kredit) as bebanDebit from jurnalumum as j, akun as a where tanggal LIKE '$request->tahun-%-%' AND akun LIKE '6%' AND j.akun = a.akunId GROUP BY akun");
                $bebanpenyesuaian = DB::select("SELECT a.nama as akun, sum(j.debit) as bebanKredit, sum(j.kredit) as bebanDebit from jurnalpenyesuaian as j, akun as a where tanggal LIKE '$request->tahun-%-%' AND akun LIKE '6%' AND j.akun = a.akunId GROUP BY akun");
                $hpp = DB::select("SELECT sum(debit)-IFNULL(sum(kredit),0) as hpp from jurnalumum where akun = 5101 AND tanggal LIKE '$request->tahun-%-%'");
                $periode = Periode::all();
                $data['bulan'] = "Jan - Des";
                $data['tahun'] = $request->tahun;
                $data['bebanpenyesuaian'] = $bebanpenyesuaian;
                $data['pendapatan'] = $pendapatan;
                $data['beban'] = $beban;
                $data['hpp'] = $hpp;
                $data['periode'] = $periode;
                if($request->action == "Print"){
                    return view('laporan_keuangan.laba_rugi_print', $data);
                }else{
                    return view('laporan_keuangan.laba_rugi', $data);
                }
            } else {
                $pendapatan = DB::select("SELECT a.nama as akun, sum(j.debit) as pendapatanKredit, sum(j.kredit) as pendapatanDebit from jurnalumum as j, akun as a where tanggal LIKE '$request->tahun-$request->bulan-%' AND akun LIKE '4%' AND akun <> '4102' AND j.akun = a.akunId GROUP BY j.akun");
                $beban = DB::select("SELECT a.nama as akun, sum(j.debit) as bebanKredit, sum(j.kredit) as bebanDebit from jurnalumum as j, akun as a where tanggal LIKE '$request->tahun-$request->bulan-%' AND akun LIKE '6%' AND j.akun = a.akunId GROUP BY akun");
                $hpp = DB::select("SELECT sum(debit)-IFNULL(sum(kredit),0) as hpp from jurnalumum where akun = 5101 AND tanggal LIKE '$request->tahun-$request->bulan-%'");
                $bebanpenyesuaian = DB::select("SELECT a.nama as akun, sum(j.debit) as bebanKredit, sum(j.kredit) as bebanDebit from jurnalpenyesuaian as j, akun as a where tanggal LIKE '$request->tahun-$request->bulan-%' AND akun LIKE '6%' AND j.akun = a.akunId GROUP BY akun");
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
                $data['bebanpenyesuaian'] = $bebanpenyesuaian;
                $data['pendapatan'] = $pendapatan;
                $data['beban'] = $beban;
                $data['hpp'] = $hpp;
                $data['periode'] = $periode;
                if($request->action == "Print"){
                    return view('laporan_keuangan.laba_rugi_print', $data);
                }else{
                    return view('laporan_keuangan.laba_rugi', $data);
                }
            }
        }
    }
}
