<?php

namespace App\Http\Controllers;

use App\Penjualan;
use App\pelanggan;
use App\Barang;
use App\JurnalPenjualan;
use Illuminate\Support\Facades\Session;
use App\JurnalKasMasuk;
use DB;
use Illuminate\Http\Request;

class PenjualanController extends Controller
{
    public function index()
    {
        if (!Session::get('login')) {
            return view('login.login');
        } else {
            $penjualan = DB::select("SELECT c.nama as c_nama, p.nama as p_nama, pj.tanggal, pj.jatuhTempo, pj.metodePembayaran, pj.keterangan, pj.status, sum(pj.harga), pj.faktur FROM penjualan as pj, pengguna as p, pelanggan as c WHERE pj.penggunaId = p.penggunaId AND pj.pelangganId = c.pelangganId GROUP BY pj.faktur");
            $data['penjualan'] = $penjualan;

            $data['tahun'] = DB::table('periode')->where('aktif', 1)->max('tahun');
            return view('penjualan.index', $data);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Session::get('login')) {
            return redirect('login');
        } else {
            $data['pelanggan'] = Pelanggan::all();
            if (DB::table('penjualan')->max('faktur') == null) {
                $data['faktur'] = 0;
            } else {
                $data['faktur'] = DB::table('penjualan')->max('faktur');
            }
            $data['barang'] = Barang::all();
            $data['penjualan'] = DB::table('penjualan')->where('faktur', 0)->get();
            $data['tahun'] = DB::table('periode')->where('aktif', 1)->max('tahun');
            $data['action'] = 'penjualan/update';
            $data['action1'] = 'penjualan/add_barang';
            return view('penjualan.form', $data);
        }
    }
    public function add_barang(Request $request)
    {
        $penjualan = new Penjualan();
        $penjualan->barangId = $request->id_barang;
        $penjualan->harga = $request->hargaJual;
        $penjualan->diskon = $request->diskon;
        $penjualan->jumlah = $request->jumlah;
        $penjualan->HPP = $request->HPP;
        $penjualan->save();

        return redirect('/penjualan/create')->with((['success' => 'Data Berhasil ditambah']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function show(Penjualan $penjualan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function edit(Penjualan $penjualan)
    {
        if (!Session::get('login')) {
            return redirect('login');
        } else {
            $penjualan = Penjualan::find($penjualan->penggunaId);
            $data['penjualan'] = $penjualan;
            $data['action'] = 'penjualan/update';
            return view('penjualan.form', $data);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Penjualan $penjualan)
    {
        if ($request->radio1 === "Tunai") {
            $status = 1;
            $jatuhtempo = $request->tanggal;
        } else {
            $status = 0;
            $jatuhtempo = $request->jatuhTempo;
        }

        $jurnalPenjualan = new JurnalPenjualan();
        $jurnalPenjualan->jurnalPenjualanTgl = $request->tanggal;
        $jurnalPenjualan->faktur = $request->faktur;
        if ($request->radio1 == 'Tunai') {
            $jurnalPenjualan->debitKas = $request->totalHarga;
            $jurnalPenjualan->keterangan = "Penjualan Tunai";
        } else {
            $jurnalPenjualan->debitPiutang = $request->totalHarga;
            $jurnalPenjualan->keterangan = "Penjualan Kredit";
        }
        $jurnalPenjualan->debitHPP = $request->totalHPP;
        $jurnalPenjualan->kreditPersediaan = $request->totalHPP;
        $jurnalPenjualan->kreditDiskon = $request->diskon;
        $jurnalPenjualan->kreditPenjualan = $request->totalHarga + $request->diskon;
        $jurnalPenjualan->save();

        DB::table('penjualan')->where('faktur', 0)
            ->update(['pelangganId' => $request->pelangganId, 'penggunaId' => session('penggunaId'), 'tanggal' => $request->tanggal, 'metodePembayaran' => $request->radio1, 'keterangan' => $request->keterangan, 'status' => $status, 'jatuhTempo' => $jatuhtempo, 'faktur' => $request->faktur]);

        if ($request->radio1 === "Tunai") {
            $jurnalKasMasuk = new JurnalKasMasuk();
            $jurnalKasMasuk->tanggal = $request->tanggal;
            $jurnalKasMasuk->faktur = "FJ-" . $request->faktur;
            $jurnalKasMasuk->kreditPenjualan = $request->totalHarga + $request->diskon;
            $jurnalKasMasuk->debitHargaPokokPenjualan = $request->totalHPP;
            $jurnalKasMasuk->kreditPersediaan = $request->totalHPP;
            $jurnalKasMasuk->debitDiskon = $request->diskon;
            $jurnalKasMasuk->debitKas = $request->totalHarga;
            $jurnalKasMasuk->save();
        }

        if ($request->radio1 === "Tunai") {
            //akun kas
            DB::table('saldoPeriode')->where('saldoPeriode.akunId', '=', '1101')->where('periode.aktif', '=', '1')
                ->join('periode', 'periode.periodeId', '=', 'saldoPeriode.periodeId')
                ->increment('saldoPeriode.saldoTotal', $request->totalHarga);

            DB::table('jurnalumum')->insert([
                'tanggal' => $request->tanggal,
                'faktur' => "FJ-" . $request->faktur,
                'akun' => '1101',
                'keterangan' => "Penjualan Tunai FJ-" . $request->faktur,
                'debit' => $request->totalHarga
            ]);

            //akun retur dan potongan penjualan
            DB::table('saldoPeriode')->where('saldoPeriode.akunId', '=', '4102')->where('periode.aktif', '=', '1')
                ->join('periode', 'periode.periodeId', '=', 'saldoPeriode.periodeId')
                ->increment('saldoPeriode.saldoTotal', $request->diskon);

            DB::table('jurnalumum')->insert([
                'tanggal' => $request->tanggal,
                'faktur' => "FJ-" . $request->faktur,
                'akun' => '4102',
                'keterangan' => "Penjualan Tunai FJ-" . $request->faktur,
                'debit' => $request->diskon
            ]);

            //akun penjualan
            DB::table('saldoPeriode')->where('saldoPeriode.akunId', '=', '4101')->where('periode.aktif', '=', '1')
                ->join('periode', 'periode.periodeId', '=', 'saldoPeriode.periodeId')
                ->increment('saldoPeriode.saldoTotal', $request->totalHarga + $request->diskon);

            DB::table('jurnalumum')->insert([
                'tanggal' => $request->tanggal,
                'faktur' => "FJ-" . $request->faktur,
                'akun' => '4101',
                'keterangan' => "Penjualan Tunai FJ-" . $request->faktur,
                'kredit' => $request->totalHarga + $request->diskon
            ]);

            //akun HPP
            DB::table('saldoPeriode')->where('saldoPeriode.akunId', '=', '5101')->where('periode.aktif', '=', '1')
                ->join('periode', 'periode.periodeId', '=', 'saldoPeriode.periodeId')
                ->increment('saldoPeriode.saldoTotal', $request->totalHPP);

            DB::table('jurnalumum')->insert([
                'tanggal' => $request->tanggal,
                'faktur' => "FJ-" . $request->faktur,
                'akun' => '5101',
                'keterangan' => "Penjualan Tunai FJ-" . $request->faktur,
                'debit' => $request->totalHPP
            ]);

            //akun persediaan
            DB::table('saldoPeriode')->where('saldoPeriode.akunId', '=', '1103')->where('periode.aktif', '=', '1')
                ->join('periode', 'periode.periodeId', '=', 'saldoPeriode.periodeId')
                ->decrement('saldoPeriode.saldoTotal', $request->totalHPP);

            DB::table('jurnalumum')->insert([
                'tanggal' => $request->tanggal,
                'faktur' => "FJ-" . $request->faktur,
                'akun' => '1103',
                'keterangan' => "Penjualan Tunai FJ-" . $request->faktur,
                'kredit' => $request->totalHPP
            ]);
        } else {
            //akun hutang usaha
            DB::table('saldoPeriode')->where('saldoPeriode.akunId', '=', '1102')->where('periode.aktif', '=', '1')
                ->join('periode', 'periode.periodeId', '=', 'saldoPeriode.periodeId')
                ->increment('saldoPeriode.saldoTotal', $request->totalHarga);

            DB::table('jurnalumum')->insert([
                'tanggal' => $request->tanggal,
                'faktur' => "FJ-" . $request->faktur,
                'akun' => '1102',
                'keterangan' => "Penjualan Kredit FJ-" . $request->faktur,
                'debit' => $request->totalHarga
            ]);
            //akun retur dan potongan penjualan
            DB::table('saldoPeriode')->where('saldoPeriode.akunId', '=', '4102')->where('periode.aktif', '=', '1')
                ->join('periode', 'periode.periodeId', '=', 'saldoPeriode.periodeId')
                ->increment('saldoPeriode.saldoTotal', $request->diskon);

            DB::table('jurnalumum')->insert([
                'tanggal' => $request->tanggal,
                'faktur' => "FJ-" . $request->faktur,
                'akun' => '4102',
                'keterangan' => "Penjualan Kredit FJ-" . $request->faktur,
                'debit' => $request->diskon
            ]);

            //akun penjualan
            DB::table('saldoPeriode')->where('saldoPeriode.akunId', '=', '4101')->where('periode.aktif', '=', '1')
                ->join('periode', 'periode.periodeId', '=', 'saldoPeriode.periodeId')
                ->increment('saldoPeriode.saldoTotal', $request->totalHarga + $request->diskon);

            DB::table('jurnalumum')->insert([
                'tanggal' => $request->tanggal,
                'faktur' => "FJ-" . $request->faktur,
                'akun' => '4101',
                'keterangan' => "Penjualan Kredit FJ-" . $request->faktur,
                'kredit' => $request->totalHarga + $request->diskon
            ]);
            //akun HPP
            DB::table('saldoPeriode')->where('saldoPeriode.akunId', '=', '5101')->where('periode.aktif', '=', '1')
                ->join('periode', 'periode.periodeId', '=', 'saldoPeriode.periodeId')
                ->increment('saldoPeriode.saldoTotal', $request->totalHPP);

            DB::table('jurnalumum')->insert([
                'tanggal' => $request->tanggal,
                'faktur' => "FJ-" . $request->faktur,
                'akun' => '5101',
                'keterangan' => "Penjualan Kredit FJ-" . $request->faktur,
                'debit' => $request->totalHPP
            ]);

            //akun persediaan
            DB::table('saldoPeriode')->where('saldoPeriode.akunId', '=', '1103')->where('periode.aktif', '=', '1')
                ->join('periode', 'periode.periodeId', '=', 'saldoPeriode.periodeId')
                ->decrement('saldoPeriode.saldoTotal', $request->totalHPP);

            DB::table('jurnalumum')->insert([
                'tanggal' => $request->tanggal,
                'faktur' => "FJ-" . $request->faktur,
                'akun' => '1103',
                'keterangan' => "Penjualan Kredit FJ-" . $request->faktur,
                'kredit' => $request->totalHPP
            ]);
        }
        return redirect('/penjualan')->with((['success' => 'Data berhasil ditambahkan']));
    }
    public function delete($id)
    {
        if (!Session::get('login')) {
            return view('login.login');
        } else {
            try {
                $penjualan = Penjualan::find($id);
                $penjualan->delete();
                return redirect('/penjualan/create')->with((['success' => 'Data ' . $penjualan->nama . ' Berhasil dihapus']));
            } catch (QueryException $ex) {
                return redirect('/penjualan/create')->with((['error' => 'Data ' . $penjualan->nama . ' Gagal dihapus karena masih digunakan pada Tabel Lain']));
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Penjualan $penjualan)
    {
        //
    }
    public function read_by_faktur($id)
    {
        if (!Session::get('login')) {
            return view('login.login');
        } else {
            $penjualan = DB::select("SELECT b.nama as b_nama, pj.jumlah, pj.harga, pj.diskon, pj.status, pj.jatuhTempo FROM penjualan as pj, barang as b WHERE faktur = $id AND b.barangId = pj.barangId");
            $returpenjualan = DB::select("SELECT rp.returPenjualanId ,b.kode, b.nama, rp.jumlah, rp.harga, pg.nama as pg_nama, p.nama as p_nama, rp.tanggal from returPenjualan rp, barang b, pelanggan pg, pengguna p WHERE rp.pelangganId = pg.pelangganId AND rp.penggunaId = p.penggunaId AND rp.barangId = b.barangId AND rp.faktur = $id AND rp.retur = 1");

            $data['returpenjualan'] = $returpenjualan;
            $data['penjualan'] = $penjualan;
            $data['faktur'] = $id;
            $data['tahun'] = DB::table('periode')->where('aktif', 1)->max('tahun');
            return view('penjualan.detail', $data);
        }
    }

    public function bayar(Request $request, Penjualan $penjualan)
    {
        DB::table("penjualan")->where('faktur', $request->faktur)
            ->update(['status' => 1]);

        //$pembelian = DB::select("SELECT b.nama as b_nama, pb.jumlah as jumlah, pb.harga as harga, pb.status FROM pembelian as pb, barang as b WHERE faktur = $request->faktur AND b.barangId = pb.barangId");
        $penjualan = DB::select("SELECT pj.jumlah as jumlah, pj.harga as harga, pj.diskon as diskon from penjualan as pj WHERE faktur = $request->faktur");
        $totalHarga = 0;
        $totalKasMasuk = 0;
        $diskon = 0;
        foreach ($penjualan as $key) {
            $totalHarga += ($key->jumlah * $key->harga);
            $diskon += $key->diskon;
        }
        $jurnalKasMasuk = new JurnalKasMasuk();
        $jurnalKasMasuk->tanggal = $request->tanggal;
        $jurnalKasMasuk->faktur = "FJ-" . $request->faktur;
        $jurnalKasMasuk->kreditPiutangUsaha = $request->totalbayar;
        $jurnalKasMasuk->debitDiskon = $diskon;
        $jurnalKasMasuk->debitKas = $request->totalbayar - $diskon;
        $jurnalKasMasuk->save();

        DB::table('jurnalumum')->insert([
            'tanggal' => $request->tanggal,
            'faktur' => "FJ-" . $request->faktur,
            'akun' => '1101',
            'keterangan' => "Pelunasan Penjualan Kredit FJ-" . $request->faktur,
            'debit' => $request->totalbayar - $diskon
        ]);

        DB::table('jurnalumum')->insert([
            'tanggal' => $request->tanggal,
            'faktur' => "FJ-" . $request->faktur,
            'akun' => '1102',
            'keterangan' => "Pelunasan Penjualan Kredit FJ-" . $request->faktur,
            'kredit' => $request->totalbayar - $diskon
        ]);

        $penjualan = DB::select("SELECT c.nama as c_nama, p.nama as p_nama, pj.tanggal, pj.jatuhTempo, pj.metodePembayaran, pj.keterangan, pj.status, sum(pj.harga), pj.faktur FROM penjualan as pj, pengguna as p, pelanggan as c WHERE pj.penggunaId = p.penggunaId AND pj.pelangganId = c.pelangganId GROUP BY pj.faktur");
        $data['penjualan'] = $penjualan;

        $data['tahun'] = DB::table('periode')->where('aktif', 1)->max('tahun');
        return view('penjualan.index', $data);
    }
}
