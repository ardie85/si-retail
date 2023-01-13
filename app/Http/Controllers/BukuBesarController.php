<?php

namespace App\Http\Controllers;

use App\BukuBesar;
use App\Periode;
use Illuminate\Support\Facades\Session;
use DB;
use Illuminate\Http\Request;

class BukuBesarController extends Controller
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
            $data['saldoAwal'] = null;
            $data['periode'] = $periode;
            return view('buku_besar.index', $data);
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
     * @param  \App\BukuBesar  $bukuBesar
     * @return \Illuminate\Http\Response
     */
    public function show(BukuBesar $bukuBesar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BukuBesar  $bukuBesar
     * @return \Illuminate\Http\Response
     */
    public function edit(BukuBesar $bukuBesar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BukuBesar  $bukuBesar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BukuBesar $bukuBesar)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BukuBesar  $bukuBesar
     * @return \Illuminate\Http\Response
     */
    public function destroy(BukuBesar $bukuBesar)
    {
        //
    }
    public function search(Request $request)
    {
        if (!Session::get('login')) {
            return view('login.login');
        } else {
            if ($request->bulan == "01") {
                $saldoAwal = DB::select("SELECT saldoperiode.saldoAwal as saldo, saldoperiode.akunId as akunid, nama, saldoNormal from saldoPeriode, periode, akun where periode.periodeid = saldoPeriode.periodeid and akun.akunid = saldoperiode.akunid and periode.tahun = $request->tahun order by saldoperiode.akunId");
            } else {
                $saldoAwal = DB::select("SELECT abs(sum(t.saldo)) as saldo, t.akunid as akunid, a.nama as nama, a.saldoNormal as saldoNormal
            from (
                select IFNULL(sum(debit),0)-IFNULL(sum(kredit),0) as saldo, akun as akunid from jurnalumum where akun <> 3101 AND jurnalumum.tanggal BETWEEN '$request->tahun-01-01' AND '$request->tahun-$request->bulan-01' - interval 1 day group by akun 
            UNION
                select IFNULL(sum(debit),0)-IFNULL(sum(kredit),0) as saldo, akun as akunid from jurnalpenyesuaian where jurnalpenyesuaian.tanggal BETWEEN '$request->tahun-01-01' AND '$request->tahun-$request->bulan-01' - interval 1 day group by akun 
            UNION
                select abs(IFNULL(sum(debit),0)-IFNULL(sum(kredit),0)) as saldo, akun as akunid from jurnalumum where akun = 3101 AND jurnalumum.tanggal BETWEEN '$request->tahun-01-01' AND '$request->tahun-$request->bulan-01' - interval 1 day group by akun 
            UNION
            SELECT saldoPeriode.saldoAwal, saldoPeriode.akunid from saldoPeriode, periode where  periode.periodeid = saldoPeriode.periodeid and periode.tahun = $request->tahun
            ) t, akun as a where t.akunid = a.akunid group by akunid");
            }
            $jurnalUmum = DB::select("SELECT * from jurnalumum where tanggal LIKE '$request->tahun-$request->bulan-%' UNION SELECT jurnalpenyesuaianId, tanggal, bebanid, akun, keterangan, debit, kredit from jurnalpenyesuaian where tanggal LIKE '$request->tahun-$request->bulan-%'");
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
            $data['saldoAwal'] = $saldoAwal;
            $data['jurnalumum'] = $jurnalUmum;
            $data['periode'] = $periode;
            if($request->action == "Print"){
                return view('buku_besar.print', $data);
            }else{
                return view('buku_besar.index', $data);
            }
        }
    }
}
