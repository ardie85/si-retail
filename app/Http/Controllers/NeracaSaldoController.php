<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Periode;
use DB;
use Illuminate\Support\Facades\Session;

class NeracaSaldoController extends Controller
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
            $data['neraca_saldo'] = null;
            $data['periode'] = $periode;
            return view('laporan_keuangan.neraca_saldo', $data);
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
            $neraca_saldo = DB::select("SELECT sum(t.saldo) as saldo, t.akunid as akunid, a.nama as nama, a.saldoNormal as saldoNormal
            from (
                select IFNULL(sum(debit),0)-IFNULL(sum(kredit),0) as saldo, akun as akunid from jurnalumum where akun <> 3101 AND jurnalumum.tanggal BETWEEN '$request->tahun-01-01' AND ('$request->tahun-$request->bulan-01'+ interval 1 month) - interval 1 day group by akun 
            UNION
                select  abs(IFNULL(sum(debit),0)-IFNULL(sum(kredit),0)) as saldo, akun as akunid from jurnalpenyesuaian where jurnalpenyesuaian.tanggal BETWEEN '$request->tahun-01-01' AND ('$request->tahun-$request->bulan-01'+ interval 1 month) - interval 1 day group by akun 
            UNION
            select abs(IFNULL(sum(debit),0)-IFNULL(sum(kredit),0)) as saldo, akun as akunid from jurnalumum where akun = 3101 AND jurnalumum.tanggal BETWEEN '$request->tahun-01-01' AND ('$request->tahun-$request->bulan-01'+ interval 1 month) - interval 1 day group by akun 
            UNION
            SELECT saldoPeriode.saldoAwal, saldoPeriode.akunid from saldoPeriode, periode where periode.periodeid = saldoPeriode.periodeid and periode.tahun = $request->tahun
            ) t, akun as a where t.akunid = a.akunid group by akunid");
            $data['tahun'] = $request->tahun;
            $periode = Periode::all();
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
            $data['neraca_saldo'] = $neraca_saldo;
            $data['periode'] = $periode;
            if($request->action == "Print"){
                return view('laporan_keuangan.neraca_saldo_print', $data);
            }else{
                return view('laporan_keuangan.neraca_saldo', $data);
            }
        }
    }
}
