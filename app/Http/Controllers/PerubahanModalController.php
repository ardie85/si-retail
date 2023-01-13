<?php

namespace App\Http\Controllers;

use App\Periode;
use Illuminate\Support\Facades\Session;
use DB;
use Illuminate\Http\Request;

class PerubahanModalController extends Controller
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
            $data['periode'] = $periode;
            $data['labaSekarang'] = null;
            $data['modalSekarang'] = null;
            return view('laporan_keuangan.perubahan_modal', $data);
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
            $pendapatan = DB::select("SELECT a.nama as akun, sum(j.debit) as pendapatanKredit, sum(j.kredit) as pendapatanDebit from jurnalumum as j, akun as a where tanggal LIKE '$request->tahun-$request->bulan-%' AND akun LIKE '4%' AND akun <> '4102' AND j.akun = a.akunId GROUP BY j.akun");
            $beban = DB::select("SELECT a.nama as akun, sum(j.debit) as bebanKredit, sum(j.kredit) as bebanDebit from jurnalumum as j, akun as a where tanggal LIKE '$request->tahun-$request->bulan-%' AND akun LIKE '6%' AND j.akun = a.akunId GROUP BY akun");
            $bebanpenyesuaian = DB::select("SELECT a.nama as akun, sum(j.debit) as bebanKredit, sum(j.kredit) as bebanDebit from jurnalpenyesuaian as j, akun as a where tanggal LIKE '$request->tahun-$request->bulan-%' AND akun LIKE '6%' AND j.akun = a.akunId GROUP BY akun");
            $hpp = DB::select("SELECT sum(debit)-IFNULL(sum(kredit),0) as hpp from jurnalumum where akun = 5101 AND tanggal LIKE '$request->tahun-$request->bulan-%'");
            $penanamanModalSekarang = DB::select("SELECT a.nama as akun, sum(j.debit) as modalDebit, sum(j.kredit) as modalKredit from jurnalumum as j, akun as a where tanggal LIKE '$request->tahun-$request->bulan-%' AND akun =3101 AND j.akun = a.akunId GROUP BY akun");
            $debitSekarang = 0;
            $kreditSekarang = 0;
            $penanamanModalSkrg = 0;
            foreach ($pendapatan as $key) {
                $debitSekarang += $key->pendapatanDebit;
                $kreditSekarang += $key->pendapatanKredit;
            }
            foreach ($beban as $key) {
                $kreditSekarang += $key->bebanKredit;
            }
            foreach ($hpp as $key) {
                $kreditSekarang += $key->hpp;
            }
            foreach($bebanpenyesuaian as $key){
                $kreditSekarang += $key->bebanKredit;
            }
            foreach($penanamanModalSekarang as $key){
                $penanamanModalSkrg = $key->modalKredit;
            }
            $labaSekarang = $debitSekarang - $kreditSekarang;

            $pendapatanDulu = DB::select("SELECT a.nama as akun, sum(j.debit) as pendapatanKredit, sum(j.kredit) as pendapatanDebit from jurnalumum as j, akun as a where tanggal BETWEEN '$request->tahun-01-01' AND '$request->tahun-$request->bulan-01' - interval 1 day AND akun LIKE '4%' AND akun <> '4102' AND j.akun = a.akunId GROUP BY j.akun");
            $bebanDulu = DB::select("SELECT a.nama as akun, sum(j.debit) as bebanKredit, sum(j.kredit) as bebanDebit from jurnalumum as j, akun as a where tanggal BETWEEN '$request->tahun-01-01' AND '$request->tahun-$request->bulan-01' - interval 1 day AND akun LIKE '6%' AND j.akun = a.akunId GROUP BY akun");
            $hppDulu = DB::select("SELECT sum(debit)-IFNULL(sum(kredit),0) as hpp from jurnalumum where akun = 5101 AND tanggal BETWEEN '$request->tahun-01-01' AND '$request->tahun-$request->bulan-01' - interval 1 day");
            $modalAwal = DB::select("SELECT sp.saldoAwal from saldoperiode sp, periode p WHERE sp.akunId = 3101 AND sp.periodeId = p.periodeid AND p.tahun = $request->tahun");
            $bebanpenyesuaianDulu = DB::select("SELECT a.nama as akun, sum(j.debit) as bebanKredit, sum(j.kredit) as bebanDebit from jurnalpenyesuaian as j, akun as a where tanggal BETWEEN '$request->tahun-01-01' AND '$request->tahun-$request->bulan-01' - interval 1 day AND akun LIKE '6%' AND j.akun = a.akunId GROUP BY akun");
            $penanamanModal = DB::select("SELECT a.nama as akun, sum(j.debit) as modalDebit, sum(j.kredit) as modalKredit from jurnalumum as j, akun as a where tanggal BETWEEN '$request->tahun-01-01' AND '$request->tahun-$request->bulan-01' - interval 1 day AND akun = 3101 AND j.akun = a.akunId GROUP BY akun");

            $debitDulu = 0;
            $kreditDulu = 0;
            $modalDulu = 0;
            $penanamanModalDulu = 0;
            foreach ($pendapatanDulu as $key) {
                $debitDulu += $key->pendapatanDebit;
                $kreditDulu += $key->pendapatanKredit;
            }
            foreach ($bebanDulu as $key) {
                $kreditDulu += $key->bebanKredit;
            }
            foreach ($hppDulu as $key) {
                $kreditDulu += $key->hpp;
            }
            foreach ($modalAwal as $key) {
                $modalDulu = $key->saldoAwal;
            }
            foreach($bebanpenyesuaianDulu as $key){
                $kreditDulu += $key->bebanKredit;
            }
            foreach($penanamanModal as $key){
                $penanamanModalDulu += $key->modalKredit;
            }

            $labaDulu = $debitDulu - $kreditDulu;

            $modalSekarang = $modalDulu + $labaDulu + $penanamanModalDulu;

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
            $data['periode'] = $periode;
            $data['labaSekarang'] = $labaSekarang;
            $data['modalSekarang'] = $modalSekarang;
            $data['penanamanModalSekarang'] = $penanamanModalSkrg;
            if($request->action == "Print"){
                return view('laporan_keuangan.perubahan_modal_print', $data);
            }else{
                return view('laporan_keuangan.perubahan_modal', $data);
            }
        }
    }
}
