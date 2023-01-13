<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Aset
        $totalAset = DB::select("SELECT sum(jumlah * harga) as total FROM aset");
        $nilaiAset = 0;
        $periode = DB::select("SELECT tahun from periode where aktif = 1");
        $tahun = 0;
        foreach ($periode as $key) {
            $tahun = $key->tahun;
        }
        foreach ($totalAset as $key) {
            $nilaiAset += $key->total;
        }
        $penyusutanAsetAktif = DB::select("SELECT FLOOR(sum(TIMESTAMPDIFF(MONTH, tanggal,'$tahun-01-01')*penyusutan)/1000)*1000 as total FROM aset where tanggal + INTERVAL aset.masaManfaat MONTH > '$tahun-01-01'");
        $nilaiPenyusutanAsetAktif = 0;
        foreach ($penyusutanAsetAktif as $key) {
            $nilaiPenyusutanAsetAktif += $key->total;
        }
        $data['nilaiAset'] = $nilaiAset;
        $data['penyusutanAsetAktif'] = $nilaiPenyusutanAsetAktif;

        //Penjualan
        $penjualan = DB::select('SELECT sum(jumlah*harga-IFNULL(diskon,0)) as total FROM `penjualan` WHERE 1');
        $returpenjualan = DB::select('SELECT sum(jumlah * harga) as total FROM `returpenjualan` WHERE 1');
        $nilaipenjualan = 0;
        foreach($penjualan as $key){
            $nilaipenjualan += $key->total;
        }
        foreach($returpenjualan as $key){
            $nilaipenjualan -= $key->total;
        }
        $data['penjualan'] = $nilaipenjualan;

        //Pembelian
        $pembelian = DB::select("SELECT sum(harga*jumlah) as total FROM `pembelian` WHERE tanggal LIKE '$tahun-%'");
        $returpembelian = DB::select("SELECT sum(jumlah*harga) as total FROM `returpembelian` WHERE tanggal LIKE '$tahun-%'");
        $nilaipembelian = 0;
        foreach($pembelian as $key){
            $nilaipembelian += $key->total;
        }
        foreach($returpembelian as $key){
            $nilaipembelian -= $key->total;
        }
        $data['pembelian'] = $nilaipembelian;

        //Barang
        $Persediaan = DB::select('SELECT sum(stok * hargaBeli) as harga FROM barang');
        $nilaiPersediaan = 0;
        foreach ($Persediaan as $key) {
            $nilaiPersediaan += $key->harga;
        }
        $data['nilaiPersediaan'] = $nilaiPersediaan;

        //Data Pembelian belum lunas
        $pembelianBelumLunas = DB::select('SELECT distinct(faktur), jatuhTempo FROM `pembelian` WHERE status = 0');
        $data['pembelianBelumLunas'] = $pembelianBelumLunas;
        
        //Data Penjualan belum lunas        
        $penjualanBelumLunas = DB::select('SELECT distinct(faktur), jatuhTempo FROM `penjualan` WHERE status = 0');
        $data['penjualanBelumLunas'] = $penjualanBelumLunas;

        //Laba Rugi
        $periode = DB::select("SELECT tahun from periode where aktif = 1");
        $tahun = 0;
        foreach ($periode as $key) {
            $tahun = $key->tahun;
        }

        $pendapatan = DB::select("SELECT MONTH(tanggal) as bulan, sum(IFNULL(j.kredit,0)-IFNULL(j.debit,0)) as pendapatan from jurnalumum as j, akun as a where akun LIKE '4%' AND akun <> '4102' AND j.akun = a.akunId AND tanggal LIKE '$tahun-%' GROUP BY MONTH(tanggal)");
        $beban = DB::select("SELECT MONTH(tanggal) as bulan, sum(j.debit) as bebanKredit from jurnalumum as j, akun as a where akun LIKE '6%' AND j.akun = a.akunId AND tanggal LIKE '$tahun-%' GROUP BY j.akun,  MONTH(tanggal)");
        $hpp = DB::select("SELECT MONTH(tanggal) as bulan, sum(debit)-IFNULL(sum(kredit),0) as hpp from jurnalumum where akun = 5101 AND tanggal LIKE '$tahun-%' GROUP BY MONTH(tanggal)");
        $bebanpenyesuaian = DB::select("SELECT MONTH(tanggal) as bulan, sum(j.debit) as bebanKredit from jurnalpenyesuaian as j, akun as a where akun LIKE '6%' AND j.akun = a.akunId AND tanggal LIKE '$tahun-%' GROUP BY MONTH(tanggal)");
        $labarugi = array(0,0,0,0,0,0,0,0,0,0,0,0);

        foreach ($pendapatan as $key) {
            $labarugi[$key->bulan - 1] = $key->pendapatan;
        }
        foreach ($beban as $key) {
            $labarugi[$key->bulan - 1] -= $key->bebanKredit;
        }
        foreach ($hpp as $key) {
            $labarugi[$key->bulan - 1] -= $key->hpp;
        }
        foreach ($bebanpenyesuaian as $key) {

            $labarugi[$key->bulan - 1] -= $key->bebanKredit;
        }

        $data['labarugi'] = $labarugi;
        $bulanArray = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus","September", "Oktober", "November", "Desember");
        $data['bulan'] = $bulanArray;
        return view('dashboard.index', $data);
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
}
