<?php

namespace App\Http\Controllers;

use App\ReturPembelian;
use DB;
use Redirect;
use App\JurnalPembelian;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Session;

use App\JurnalKasMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect as FacadesRedirect;

class ReturPembelianController extends Controller
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
            //SELECT DISTINCT(faktur) from pembelian
            $retur = DB::select("SELECT DISTINCT(faktur) from pembelian");
            $dataReturAll = DB::select("SELECT rp.returPembelianId ,b.kode, b.nama, rp.jumlah, rp.harga, s.nama as s_nama, p.nama as p_nama, rp.tanggal, rp.faktur, rp.keterangan from returpembelian rp, barang b, supplier s, pengguna p WHERE rp.supplierId = s.supplierId AND rp.penggunaId = p.penggunaId AND rp.barangId = b.barangId AND rp.retur = 1 GROUP BY rp.faktur");
            $data['action'] = 'retur_pembelian/proses';
            $data['retur'] = $retur;
            $data['dataReturAll'] = $dataReturAll;
            return view('retur_barang.index_retur_pembelian', $data);
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
     * @param  \App\ReturPembelian  $returPembelian
     * @return \Illuminate\Http\Response
     */
    public function show(ReturPembelian $returPembelian)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ReturPembelian  $returPembelian
     * @return \Illuminate\Http\Response
     */
    public function edit(ReturPembelian $returPembelian)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ReturPembelian  $returPembelian
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReturPembelian $returPembelian)
    {
        DB::table('returpembelian')->where('retur', 0)
            ->update(['tanggal' => $request->tanggal, 'metodePembayaran' => $request->metodePembayaran, 'keterangan' => $request->keterangan, 'retur' => 1]);

        //jika tunai
        if ($request->metodePembayaran == "Tunai") {
            //Jurnal Kas Masuk
            $jurnalKasMasuk = new JurnalKasMasuk();
            $jurnalKasMasuk->tanggal = $request->tanggal;
            $jurnalKasMasuk->faktur = "FB-" . $request->faktur;
            $jurnalKasMasuk->kreditPersediaan = $request->totalHarga;
            $jurnalKasMasuk->debitKas = $request->totalHarga;
            $jurnalKasMasuk->save();

            //Jurnal Pembelian
            $jurnalPembelian = new JurnalPembelian();
            $jurnalPembelian->jurnalPembelianTgl = $request->tanggal;
            $jurnalPembelian->faktur =  $request->faktur;
            $jurnalPembelian->kreditPersediaan = $request->totalHarga;
            $jurnalPembelian->debitKas = $request->totalHarga;
            $jurnalPembelian->keterangan = "Retur Pembelian Tunai";
            $jurnalPembelian->save();

            //Akun Kas
            DB::table('saldoPeriode')->where('saldoPeriode.akunId', '=', '1101')->where('periode.aktif', '=', '1')
                ->join('periode', 'periode.periodeId', '=', 'saldoPeriode.periodeId')
                ->increment('saldoPeriode.saldoTotal', $request->totalHarga);

            DB::table('jurnalumum')->insert([
                'tanggal' => $request->tanggal,
                'faktur' => "FB-" . $request->faktur,
                'akun' => '1101',
                'keterangan' => "Retur Pembelian Tunai FB-" . $request->faktur,
                'debit' => $request->totalHarga
            ]);

            //Akun Persediaan
            DB::table('saldoPeriode')->where('saldoPeriode.akunId', '=', '1103')->where('periode.aktif', '=', '1')
                ->join('periode', 'periode.periodeId', '=', 'saldoPeriode.periodeId')
                ->decrement('saldoPeriode.saldoTotal', $request->totalHarga);

            DB::table('jurnalumum')->insert([
                'tanggal' => $request->tanggal,
                'faktur' => "FB-" . $request->faktur,
                'akun' => '1103',
                'keterangan' => "Retur Pembelian Tunai FB-" . $request->faktur,
                'kredit' => $request->totalHarga
            ]);
        } else {
            if ($request->status) {
                //Jurnal Kas Masuk
                $jurnalKasMasuk = new JurnalKasMasuk();
                $jurnalKasMasuk->tanggal = $request->tanggal;
                $jurnalKasMasuk->faktur = "FB-" . $request->faktur;
                $jurnalKasMasuk->kreditPersediaan = $request->totalHarga;
                $jurnalKasMasuk->debitKas = $request->totalHarga;
                $jurnalKasMasuk->save();

                //Jurnal Pembelian
                $jurnalPembelian = new JurnalPembelian();
                $jurnalPembelian->jurnalPembelianTgl = $request->tanggal;
                $jurnalPembelian->faktur =  $request->faktur;
                $jurnalPembelian->kreditPersediaan = $request->totalHarga;
                $jurnalPembelian->debitKas = $request->totalHarga;
                $jurnalPembelian->keterangan = "Retur Pembelian Kredit";
                $jurnalPembelian->save();

                //Akun Kas
                DB::table('saldoPeriode')->where('saldoPeriode.akunId', '=', '1101')->where('periode.aktif', '=', '1')
                    ->join('periode', 'periode.periodeId', '=', 'saldoPeriode.periodeId')
                    ->increment('saldoPeriode.saldoTotal', $request->totalHarga);

                DB::table('jurnalumum')->insert([
                    'tanggal' => $request->tanggal,
                    'faktur' => "FB-" . $request->faktur,
                    'akun' => '1101',
                    'keterangan' => "Retur Pembelian Kredit FB-" . $request->faktur,
                    'debit' => $request->totalHarga
                ]);

                //Akun Persediaan
                DB::table('saldoPeriode')->where('saldoPeriode.akunId', '=', '1103')->where('periode.aktif', '=', '1')
                    ->join('periode', 'periode.periodeId', '=', 'saldoPeriode.periodeId')
                    ->decrement('saldoPeriode.saldoTotal', $request->totalHarga);

                DB::table('jurnalumum')->insert([
                    'tanggal' => $request->tanggal,
                    'faktur' => "FB-" . $request->faktur,
                    'akun' => '1103',
                    'keterangan' => "Retur Pembelian Kredit FB-" . $request->faktur,
                    'kredit' => $request->totalHarga
                ]);
            } else {
                //Jurnal Pembelian
                $jurnalPembelian = new JurnalPembelian();
                $jurnalPembelian->jurnalPembelianTgl = $request->tanggal;
                $jurnalPembelian->faktur =  $request->faktur;
                $jurnalPembelian->kreditPersediaan = $request->totalHarga;
                $jurnalPembelian->debitHutang = $request->totalHarga;
                $jurnalPembelian->keterangan = "Retur Pembelian Kredit";
                $jurnalPembelian->save();
                
                //Akun Utang Usaha
                DB::table('saldoPeriode')->where('saldoPeriode.akunId', '=', '2101')->where('periode.aktif', '=', '1')
                    ->join('periode', 'periode.periodeId', '=', 'saldoPeriode.periodeId')
                    ->decrement('saldoPeriode.saldoTotal', $request->totalHarga);

                DB::table('jurnalumum')->insert([
                    'tanggal' => $request->tanggal,
                    'faktur' => "FB-" . $request->faktur,
                    'akun' => '2101',
                    'keterangan' => "Retur Pembelian Kredit FB-" . $request->faktur,
                    'debit' => $request->totalHarga
                ]);

                //Akun Retur Pembelian
                DB::table('saldoPeriode')->where('saldoPeriode.akunId', '=', '1103')->where('periode.aktif', '=', '1')
                    ->join('periode', 'periode.periodeId', '=', 'saldoPeriode.periodeId')
                    ->increment('saldoPeriode.saldoTotal', $request->totalHarga);

                DB::table('jurnalumum')->insert([
                    'tanggal' => $request->tanggal,
                    'faktur' => "FB-" . $request->faktur,
                    'akun' => '1103',
                    'keterangan' => "Retur Pembelian Kredit FB-" . $request->faktur,
                    'kredit' => $request->totalHarga
                ]);
            }
        }

        return redirect('retur_pembelian');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ReturPembelian  $returPembelian
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReturPembelian $returPembelian)
    {
        //
    }

    public function delete($id)
    {
        if (!Session::get('login')) {
            return view('login.login');
        } else {
            try {
                $retur_pembelian = ReturPembelian::find($id);
                $retur_pembelian->delete();
                return redirect('/retur_pembelian/proses/' . Session::get('faktur'));
            } catch (QueryException $ex) {
            }
        }
    }

    public function proses(Request $request)
    {
        if (!Session::get('login')) {
            return view('login.login');
        } else {
            Session::put('faktur', $request->faktur);
            $pembelian = DB::select("SELECT b.nama as b_nama, pb.jumlah, pb.harga, b.barangId as barangId, pb.status FROM pembelian as pb, barang as b WHERE faktur = $request->faktur AND b.barangId = pb.barangId");
            $supplier = DB::select("SELECT distinct(supplier.nama), supplier.supplierId from supplier, pembelian WHERE supplier.supplierId = pembelian.supplierId AND pembelian.faktur = $request->faktur");
            $pengguna = DB::select("SELECT distinct(pengguna.nama), pengguna.penggunaId from pengguna, pembelian WHERE pengguna.penggunaId = pembelian.penggunaId AND pembelian.faktur = $request->faktur");
            $metodePembayaran = DB::select("SELECT distinct(metodePembayaran) from pembelian WHERE pembelian.faktur = $request->faktur");
            $dataRetur = DB::select("SELECT rp.returPembelianId ,b.kode, b.nama, rp.jumlah, rp.harga from returpembelian rp, barang b WHERE rp.barangId = b.barangId AND rp.faktur = $request->faktur AND rp.retur = 0");

            $data['tanggal'] = DB::select("SELECT distinct(tanggal) from pembelian where faktur = $request->faktur");
            $data['dataRetur'] = $dataRetur;
            $data['action'] = 'retur_pembelian/update';
            $data['action1'] = 'retur_pembelian/add_barang';
            $data['pembelian'] = $pembelian;
            $data['faktur'] = $request->faktur;
            $data['supplier'] = $supplier;
            $data['pengguna'] = $pengguna;
            $data['metodePembayaran'] = $metodePembayaran;
            return view('retur_barang.form_retur_pembelian', $data);
        }
    }

    public function detail($id)
    {
        if (!Session::get('login')) {
            return view('login.login');
        } else {
            $returpembelian = DB::select("SELECT rp.returPembelianId ,b.kode, b.nama, rp.jumlah, rp.harga, s.nama as s_nama, p.nama as p_nama, rp.tanggal from returpembelian rp, barang b, supplier s, pengguna p WHERE rp.supplierId = s.supplierId AND rp.penggunaId = p.penggunaId AND rp.barangId = b.barangId AND rp.faktur = $id AND rp.retur = 1");
            $data['returpembelian'] = $returpembelian;
            $data['faktur'] = $id;
            return view('retur_barang.detail_retur_pembelian', $data);
        }
    }

    public function add_barang(Request $request)
    {
        $retur_pembelian = new ReturPembelian();
        $retur_pembelian->faktur = $request->faktur;
        $retur_pembelian->jumlah = $request->jumlah_retur;
        $retur_pembelian->barangId = $request->barangId;
        $retur_pembelian->supplierId = $request->supplierId;
        $retur_pembelian->penggunaId = $request->penggunaId;
        $retur_pembelian->harga = $request->harga;
        $retur_pembelian->save();

        return redirect('retur_pembelian/proses/' . $request->faktur);
    }
}
