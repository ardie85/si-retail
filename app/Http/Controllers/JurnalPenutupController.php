<?php

namespace App\Http\Controllers;

use App\JurnalPenutup;
use App\Periode;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class JurnalPenutupController extends Controller
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
            $data['neracaSaldo'] = null;
            $data['penjualan'] = null;
            $data['periode'] = $periode;
            return view('jurnal_penutup.index', $data);
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
     * @param  \App\JurnalPenutup  $jurnalPenutup
     * @return \Illuminate\Http\Response
     */
    public function show(JurnalPenutup $jurnalPenutup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\JurnalPenutup  $jurnalPenutup
     * @return \Illuminate\Http\Response
     */
    public function edit(JurnalPenutup $jurnalPenutup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\JurnalPenutup  $jurnalPenutup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, JurnalPenutup $jurnalPenutup)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\JurnalPenutup  $jurnalPenutup
     * @return \Illuminate\Http\Response
     */
    public function destroy(JurnalPenutup $jurnalPenutup)
    {
        //
    }

    public function search(Request $request)
    {
        if (!Session::get('login')) {
            return view('login.login');
        } else {
            // $penjualan = DB::select("SELECT saldoperiode.saldoTotal FROM saldoperiode, periode where saldoperiode.akunId = 4101 AND saldoperiode.periodeId = periode.periodeId AND periode.tahun = $request->tahun");
            // $returPenjualan = DB::select("SELECT saldoperiode.saldoTotal FROM saldoperiode, periode WHERE saldoperiode.akunId = 4104 AND saldoperiode.periodeId = periode.periodeId AND periode.tahun = $request->tahun");
            // $pendapatan = DB::select("SELECT saldoperiode.saldoTotal FROM saldoperiode, periode WHERE saldoperiode.akunId = 4103 AND saldoperiode.periodeId = periode.periodeId AND periode.tahun = $request->tahun");
            //$beban = DB::select("SELECT akun.nama, saldoperiode.saldoTotal FROM saldoperiode,periode,akun WHERE saldoperiode.akunId = akun.akunid AND saldoperiode.akunId LIKE '61__' AND saldoperiode.periodeId = periode.periodeId AND periode.tahun = $request->tahun");
            $rowcountbeban = DB::select("SELECT count(*) as total from saldoperiode,periode WHERE saldoperiode.periodeId = periode.periodeId AND saldoperiode.akunId  LIKE '61__' AND periode.tahun = $request->tahun ");
            // $hpp = DB::select("SELECT saldoperiode.saldoTotal FROM saldoperiode, periode WHERE saldoperiode.akunId = 5101 AND saldoperiode.periodeId = periode.periodeId AND periode.tahun = $request->tahun");
            // $diskon = DB::select("SELECT sum(saldoperiode.saldoTotal) as saldoTotal FROM saldoperiode, periode WHERE saldoperiode.akunId = 4102 AND saldoperiode.periodeId = periode.periodeId AND periode.tahun = $request->tahun");
            // $modal = DB::select("SELECT saldoperiode.saldoTotal FROM saldoperiode, periode WHERE saldoperiode.akunId = 3101 AND saldoperiode.periodeId = periode.periodeId AND periode.tahun = $request->tahun");


            // $ikhLabaRugi2 = 0;
            // foreach ($beban as $key => $value) {
            //     $ikhLabaRugi2 += $value->saldoTotal;
            // }
            // $ikhLabaRugi2 += $hpp[0]->saldoTotal;


            // $data['modal'] = $modal;
            //$data['ikhLabaRugi2'] = $ikhLabaRugi2;
            // $data['hpp'] = $hpp;
            // $data['diskon'] = $diskon;
            // $data['returPenjualan']= $returPenjualan;
            // $data['pendapatan']= $pendapatan;
            // $data['beban'] = $beban;
            $data['rowcountbeban'] = $rowcountbeban;
            $periode = Periode::all();
            $data['tahun'] = $request->tahun;
            // $data['penjualan'] = $penjualan;

            $neracaSaldo = DB::select("SELECT sum(t.saldo) as saldo, t.akunid as akunid, a.nama as nama, a.saldoNormal as saldoNormal
            from (
                select abs(IFNULL(sum(debit),0)-IFNULL(sum(kredit),0)) as saldo, akun as akunid from jurnalumum where jurnalumum.tanggal BETWEEN '$request->tahun-01-01' AND '$request->tahun-12-01'+ interval 1 month group by akun 
            UNION
                select  abs(IFNULL(sum(debit),0)-IFNULL(sum(kredit),0)) as saldo, akun as akunid from jurnalpenyesuaian where jurnalpenyesuaian.tanggal BETWEEN '$request->tahun-01-01' AND '$request->tahun-12-01'+ interval 1 month group by akun 
            UNION
            SELECT saldoPeriode.saldoAwal, saldoPeriode.akunid from saldoPeriode, periode where periode.periodeid = saldoPeriode.periodeid and periode.tahun = $request->tahun
            ) t, akun as a where t.akunid = a.akunid group by akunid");

            $beban = DB::select("SELECT sum(t.saldo) as saldo, t.akunid as akunid, a.nama as nama, a.saldoNormal as saldoNormal
            from (
                select abs(IFNULL(sum(debit),0)-IFNULL(sum(kredit),0)) as saldo, akun as akunid from jurnalumum where jurnalumum.tanggal BETWEEN '$request->tahun-01-01' AND '$request->tahun-12-01'+ interval 1 month group by akun 
            UNION
                select  abs(IFNULL(sum(debit),0)-IFNULL(sum(kredit),0)) as saldo, akun as akunid from jurnalpenyesuaian where jurnalpenyesuaian.tanggal BETWEEN '$request->tahun-01-01' AND '$request->tahun-12-01'+ interval 1 month group by akun 
            UNION
            SELECT saldoPeriode.saldoAwal, saldoPeriode.akunid from saldoPeriode, periode where periode.periodeid = saldoPeriode.periodeid and periode.tahun = $request->tahun
            ) t, akun as a where t.akunid = a.akunid AND t.akunid LIKE '6%' group by akunid");

            $ikhLabaRugi2 = 0;
            foreach ($beban as $key) {
                $ikhLabaRugi2 += $key->saldo;
            }
            $data['ikhLabaRugi2'] = $ikhLabaRugi2;
            $data['beban'] = $beban;
            $data['neracaSaldo'] = $neracaSaldo;
            $data['periode'] = $periode;
            if($request->action == "Print"){
                return view('jurnal_penutup.print', $data);
            }else{
                return view('jurnal_penutup.index', $data);
            }
        }
    }
}
