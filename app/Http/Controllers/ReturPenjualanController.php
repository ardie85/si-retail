<?php

namespace App\Http\Controllers;

use App\ReturPenjualan;
use DB;
use Redirect;
use App\JurnalKasKeluar;
use App\JurnalPenjualan;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect as FacadesRedirect;

class ReturPenjualanController extends Controller
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
            $retur = DB::select("SELECT DISTINCT(faktur) from penjualan");
            $data['action'] = 'retur_penjualan/proses';
            $data['retur'] = $retur;
            $dataReturAll = DB::select("SELECT rp.returPenjualanId ,b.kode, b.nama, rp.jumlah, rp.harga, c.nama as c_nama, p.nama as p_nama, rp.tanggal, rp.faktur, rp.keterangan from returpenjualan rp, barang b, pelanggan c, pengguna p WHERE rp.pelangganId = c.pelangganId AND rp.penggunaId = p.penggunaId AND rp.barangId = b.barangId AND rp.retur = 1 GROUP BY rp.faktur");
            $data['dataReturAll'] = $dataReturAll;
            return view('retur_barang.index_retur_penjualan', $data);
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
     * @param  \App\ReturPenjualan  $returPenjualan
     * @return \Illuminate\Http\Response
     */
    public function show(ReturPenjualan $returPenjualan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ReturPenjualan  $returPenjualan
     * @return \Illuminate\Http\Response
     */
    public function edit(ReturPenjualan $returPenjualan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ReturPenjualan  $returPenjualan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReturPenjualan $returPenjualan)
    {

        DB::table('returpenjualan')->where('retur', 0)
            ->update(['tanggal' => $request->tanggal, 'metodePembayaran' => $request->metodePembayaran, 'keterangan' => $request->keterangan, 'retur' => 1]);


        if ($request->metodePembayaran == "Tunai") {
            //Jurnal Kas Keluar
            $jurnalKasKeluar = new JurnalKasKeluar();
            $jurnalKasKeluar->tanggal = $request->tanggal;
            $jurnalKasKeluar->faktur = "FJ-" . $request->faktur;
            $jurnalKasKeluar->debitReturPenjualan = $request->totalHarga;
            $jurnalKasKeluar->kreditKas = $request->totalHarga;
            $jurnalKasKeluar->debitPersediaan = $request->hpp;
            $jurnalKasKeluar->kreditHargaPokokPenjualan = $request->hpp;
            $jurnalKasKeluar->save();

            //Jurnal Penjualan
            $jurnalPenjualan = new JurnalPenjualan();
            $jurnalPenjualan->jurnalPenjualanTgl = $request->tanggal;
            $jurnalPenjualan->faktur = $request->faktur;
            $jurnalPenjualan->debitReturPenjualan = $request->totalHarga;
            $jurnalPenjualan->kreditKas = $request->totalHarga;
            $jurnalPenjualan->debitPersediaan = $request->hpp;
            $jurnalPenjualan->kreditHPP = $request->hpp;
            $jurnalPenjualan->keterangan = "Retur Penjualan Tunai";
            $jurnalPenjualan->save();

            //Akun Retur Penjualan
            DB::table('saldoPeriode')->where('saldoPeriode.akunId', '=', '4104')->where('periode.aktif', '=', '1')
                ->join('periode', 'periode.periodeId', '=', 'saldoPeriode.periodeId')
                ->increment('saldoPeriode.saldoTotal', $request->totalHarga);

            DB::table('jurnalumum')->insert([
                'tanggal' => $request->tanggal,
                'faktur' => "FJ-" . $request->faktur,
                'akun' => '4104',
                'keterangan' => "Retur Penjualan Tunai FJ-" . $request->faktur,
                'debit' => $request->totalHarga
            ]);

            //Akun Kas
            DB::table('saldoPeriode')->where('saldoPeriode.akunId', '=', '1101')->where('periode.aktif', '=', '1')
                ->join('periode', 'periode.periodeId', '=', 'saldoPeriode.periodeId')
                ->decrement('saldoPeriode.saldoTotal', $request->totalHarga);

            DB::table('jurnalumum')->insert([
                'tanggal' => $request->tanggal,
                'faktur' => "FJ-" . $request->faktur,
                'akun' => '1101',
                'keterangan' => "Retur Penjualan Tunai FJ-" . $request->faktur,
                'kredit' => $request->totalHarga
            ]);

            //Akun Persediaan
            DB::table('saldoPeriode')->where('saldoPeriode.akunId', '=', '1103')->where('periode.aktif', '=', '1')
                ->join('periode', 'periode.periodeId', '=', 'saldoPeriode.periodeId')
                ->increment('saldoPeriode.saldoTotal', $request->hpp);

            DB::table('jurnalumum')->insert([
                'tanggal' => $request->tanggal,
                'faktur' => "FJ-" . $request->faktur,
                'akun' => '1103',
                'keterangan' => "Retur Penjualan Tunai FJ-" . $request->faktur,
                'debit' => $request->hpp
            ]);

            //Akun HPP
            DB::table('saldoPeriode')->where('saldoPeriode.akunId', '=', '5101')->where('periode.aktif', '=', '1')
                ->join('periode', 'periode.periodeId', '=', 'saldoPeriode.periodeId')
                ->decrement('saldoPeriode.saldoTotal', $request->hpp);

            DB::table('jurnalumum')->insert([
                'tanggal' => $request->tanggal,
                'faktur' => "FJ-" . $request->faktur,
                'akun' => '5101',
                'keterangan' => "Retur Penjualan Tunai FJ-" . $request->faktur,
                'kredit' => $request->hpp
            ]);
        } else {
            if ($request->status) {
                //Jurnal Kas Keluar
                $jurnalKasKeluar = new JurnalKasKeluar();
                $jurnalKasKeluar->tanggal = $request->tanggal;
                $jurnalKasKeluar->faktur = "FJ-" . $request->faktur;
                $jurnalKasKeluar->debitReturPenjualan = $request->totalHarga;
                $jurnalKasKeluar->kreditKas = $request->totalHarga;
                $jurnalKasKeluar->debitPersediaan = $request->hpp;
                $jurnalKasKeluar->kreditHargaPokokPenjualan = $request->hpp;
                $jurnalKasKeluar->save();

                //Jurnal Penjualan
                $jurnalPenjualan = new JurnalPenjualan();
                $jurnalPenjualan->jurnalPenjualanTgl = $request->tanggal;
                $jurnalPenjualan->faktur = $request->faktur;
                $jurnalPenjualan->debitReturPenjualan = $request->totalHarga;
                $jurnalPenjualan->kreditKas = $request->totalHarga;
                $jurnalPenjualan->debitPersediaan = $request->hpp;
                $jurnalPenjualan->kreditHPP = $request->hpp;
                $jurnalPenjualan->keterangan = "Retur Penjualan Kredit";
                $jurnalPenjualan->save();

                //Akun Retur Penjualan
                DB::table('saldoPeriode')->where('saldoPeriode.akunId', '=', '4104')->where('periode.aktif', '=', '1')
                    ->join('periode', 'periode.periodeId', '=', 'saldoPeriode.periodeId')
                    ->increment('saldoPeriode.saldoTotal', $request->totalHarga);

                DB::table('jurnalumum')->insert([
                    'tanggal' => $request->tanggal,
                    'faktur' => "FJ-" . $request->faktur,
                    'akun' => '4104',
                    'keterangan' => "Retur Penjualan Kredit FJ-" . $request->faktur,
                    'debit' => $request->totalHarga
                ]);

                //Akun Kas
                DB::table('saldoPeriode')->where('saldoPeriode.akunId', '=', '1101')->where('periode.aktif', '=', '1')
                    ->join('periode', 'periode.periodeId', '=', 'saldoPeriode.periodeId')
                    ->decrement('saldoPeriode.saldoTotal', $request->totalHarga);

                DB::table('jurnalumum')->insert([
                    'tanggal' => $request->tanggal,
                    'faktur' => "FJ-" . $request->faktur,
                    'akun' => '1101',
                    'keterangan' => "Retur Penjualan Kredit FJ-" . $request->faktur,
                    'kredit' => $request->totalHarga
                ]);

                //Akun Persediaan
                DB::table('saldoPeriode')->where('saldoPeriode.akunId', '=', '1103')->where('periode.aktif', '=', '1')
                    ->join('periode', 'periode.periodeId', '=', 'saldoPeriode.periodeId')
                    ->increment('saldoPeriode.saldoTotal', $request->hpp);

                DB::table('jurnalumum')->insert([
                    'tanggal' => $request->tanggal,
                    'faktur' => "FJ-" . $request->faktur,
                    'akun' => '1103',
                    'keterangan' => "Retur Penjualan Kredit FJ-" . $request->faktur,
                    'debit' => $request->hpp
                ]);

                //Akun HPP
                DB::table('saldoPeriode')->where('saldoPeriode.akunId', '=', '5101')->where('periode.aktif', '=', '1')
                    ->join('periode', 'periode.periodeId', '=', 'saldoPeriode.periodeId')
                    ->decrement('saldoPeriode.saldoTotal', $request->hpp);

                DB::table('jurnalumum')->insert([
                    'tanggal' => $request->tanggal,
                    'faktur' => "FJ-" . $request->faktur,
                    'akun' => '5101',
                    'keterangan' => "Retur Penjualan Kredit FJ-" . $request->faktur,
                    'kredit' => $request->hpp
                ]);
            } else {
                //Jurnal Penjualan
                $jurnalPenjualan = new JurnalPenjualan();
                $jurnalPenjualan->jurnalPenjualanTgl = $request->tanggal;
                $jurnalPenjualan->faktur = $request->faktur;
                $jurnalPenjualan->debitReturPenjualan = $request->totalHarga;
                $jurnalPenjualan->kreditPiutang = $request->totalHarga;
                $jurnalPenjualan->debitPersediaan = $request->hpp;
                $jurnalPenjualan->kreditHPP = $request->hpp;
                $jurnalPenjualan->keterangan = "Retur Penjualan Tunai";
                $jurnalPenjualan->save();

                //Akun Retur Penjualan
                DB::table('saldoPeriode')->where('saldoPeriode.akunId', '=', '4104')->where('periode.aktif', '=', '1')
                    ->join('periode', 'periode.periodeId', '=', 'saldoPeriode.periodeId')
                    ->increment('saldoPeriode.saldoTotal', $request->totalHarga);

                DB::table('jurnalumum')->insert([
                    'tanggal' => $request->tanggal,
                    'faktur' => "FJ-" . $request->faktur,
                    'akun' => '4104',
                    'keterangan' => "Retur Penjualan Kredit FJ-" . $request->faktur,
                    'debit' => $request->totalHarga
                ]);

                //Akun Piutang Usaha
                DB::table('saldoPeriode')->where('saldoPeriode.akunId', '=', '1102')->where('periode.aktif', '=', '1')
                    ->join('periode', 'periode.periodeId', '=', 'saldoPeriode.periodeId')
                    ->decrement('saldoPeriode.saldoTotal', $request->totalHarga);

                DB::table('jurnalumum')->insert([
                    'tanggal' => $request->tanggal,
                    'faktur' => "FJ-" . $request->faktur,
                    'akun' => '1102',
                    'keterangan' => "Retur Penjualan Kredit FJ-" . $request->faktur,
                    'kredit' => $request->totalHarga
                ]);

                //Akun Persediaan
                DB::table('saldoPeriode')->where('saldoPeriode.akunId', '=', '1103')->where('periode.aktif', '=', '1')
                    ->join('periode', 'periode.periodeId', '=', 'saldoPeriode.periodeId')
                    ->increment('saldoPeriode.saldoTotal', $request->hpp);

                DB::table('jurnalumum')->insert([
                    'tanggal' => $request->tanggal,
                    'faktur' => "FJ-" . $request->faktur,
                    'akun' => '1103',
                    'keterangan' => "Retur Penjualan Kredit FJ-" . $request->faktur,
                    'debit' => $request->hpp
                ]);

                //Akun HPP
                DB::table('saldoPeriode')->where('saldoPeriode.akunId', '=', '5101')->where('periode.aktif', '=', '1')
                    ->join('periode', 'periode.periodeId', '=', 'saldoPeriode.periodeId')
                    ->decrement('saldoPeriode.saldoTotal', $request->hpp);

                DB::table('jurnalumum')->insert([
                    'tanggal' => $request->tanggal,
                    'faktur' => "FJ-" . $request->faktur,
                    'akun' => '5101',
                    'keterangan' => "Retur Penjualan Kredit FJ-" . $request->faktur,
                    'kredit' => $request->hpp
                ]);
            }
        }

        return redirect('retur_penjualan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ReturPenjualan  $returPenjualan
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReturPenjualan $returPenjualan)
    {
        //
    }

    public function delete($id)
    {
        if (!Session::get('login')) {
            return view('login.login');
        } else {
            try {
                $retur_penjualan = ReturPenjualan::find($id);
                $retur_penjualan->delete();
                return redirect('/retur_penjualan/proses/' . Session::get('faktur_penjualan'));
            } catch (QueryException $ex) {
            }
        }
    }

    public function proses(Request $request)
    {
        Session::put('faktur_penjualan', $request->faktur);
        $penjualan = DB::select("SELECT b.nama as b_nama, pj.jumlah, pj.harga, b.barangId as barangId, pj.status, pj.hpp FROM penjualan as pj, barang as b WHERE faktur = $request->faktur AND b.barangId = pj.barangId");
        $pelanggan = DB::select("SELECT distinct(pelanggan.nama), pelanggan.pelangganId from pelanggan, penjualan WHERE pelanggan.pelangganId = penjualan.pelangganId AND penjualan.faktur = $request->faktur");
        $pengguna = DB::select("SELECT distinct(pengguna.nama), pengguna.penggunaId from pengguna, penjualan WHERE pengguna.penggunaId = penjualan.penggunaId AND penjualan.faktur = $request->faktur");
        $metodePembayaran = DB::select("SELECT distinct(metodePembayaran) from penjualan WHERE penjualan.faktur = $request->faktur");
        $dataRetur = DB::select("SELECT rp.returPenjualanId ,b.kode, b.nama, rp.jumlah, rp.harga, c.nama as c_nama, p.nama as p_nama, rp.tanggal, rp.hpp from returPenjualan rp, barang b, pelanggan c, pengguna p WHERE rp.pelangganId = c.pelangganId AND rp.penggunaId = p.penggunaId AND rp.barangId = b.barangId AND rp.faktur = $request->faktur AND rp.retur = 0");

        $data['tanggal'] = DB::select("SELECT distinct(tanggal) from penjualan where faktur = $request->faktur");
        $data['dataRetur'] = $dataRetur;
        $data['action'] = 'retur_penjualan/update';
        $data['action1'] = 'retur_penjualan/add_barang';
        $data['penjualan'] = $penjualan;
        $data['faktur'] = $request->faktur;
        $data['pelanggan'] = $pelanggan;
        $data['pengguna'] = $pengguna;
        $data['metodePembayaran'] = $metodePembayaran;
        return view('retur_barang.form_retur_penjualan', $data);
    }

    public function detail($id)
    {
        if (!Session::get('login')) {
            return view('login.login');
        } else {
            $returpenjualan = DB::select("SELECT rp.returPenjualanId ,b.kode, b.nama, rp.jumlah, rp.harga, c.nama as c_nama, p.nama as p_nama, rp.tanggal from returPenjualan rp, barang b, pelanggan c, pengguna p WHERE rp.pelangganId = c.pelangganId AND rp.penggunaId = p.penggunaId AND rp.barangId = b.barangId AND rp.faktur = $id AND rp.retur = 1");
            $data['returpenjualan'] = $returpenjualan;
            $data['faktur'] = $id;
            return view('retur_barang.detail_retur_penjualan', $data);
        }
    }

    public function add_barang(Request $request)
    {
        $retur_penjualan = new ReturPenjualan();
        $retur_penjualan->faktur = $request->faktur;
        $retur_penjualan->jumlah = $request->jumlah_retur;
        $retur_penjualan->barangId = $request->barangId;
        $retur_penjualan->pelangganId = $request->pelangganId;
        $retur_penjualan->penggunaId = $request->penggunaId;
        $retur_penjualan->harga = $request->harga;
        $retur_penjualan->hpp = $request->hpp;
        $retur_penjualan->save();

        return redirect('retur_penjualan/proses/' . $request->faktur);
    }
}
