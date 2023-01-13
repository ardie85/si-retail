<?php

namespace App\Http\Controllers;

use App\Pembelian;
use App\barang;
use App\JurnalPembelian;
use App\supplier;
use App\JurnalKasKeluar;
use DB;
use Hamcrest\Core\IsEqual;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use PHPUnit\Framework\Constraint\IsEmpty;

class PembelianController extends Controller
{
    public function index()
    {
        if (!Session::get('login')) {
            return view('login.login');
        } else {
            //$pembelian = Pembelian::all();
            $pembelian = DB::select("SELECT s.nama as s_nama,p.nama as p_nama,pb.tanggal,pb.metodePembayaran,pb.keterangan,pb.status,pb.jatuhTempo, sum(pb.harga) as harga, pb.faktur FROM pembelian as pb, supplier as s, pengguna as p WHERE pb.supplierId = s.supplierId AND pb.penggunaId = p.penggunaId GROUP BY pb.faktur");
            $data['pembelian'] = $pembelian;
            $data['tahun'] = DB::table('periode')->where('aktif', 1)->max('tahun');
            return view('pembelian.index', $data);
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
            $data['supplier'] = Supplier::all();
            if (DB::table('pembelian')->max('faktur') == null) {
                $data['faktur'] = 0;
            } else {
                $data['faktur'] = DB::table('pembelian')->max('faktur');
            }
            $data['barang'] = Barang::all();
            $data['pembelian'] = DB::table('pembelian')->where('faktur', 0)->get();
            $data['tahun'] = DB::table('periode')->where('aktif', 1)->max('tahun');
            $data['action'] = 'pembelian/update';
            $data['action1'] = 'pembelian/add_barang';
            return view('pembelian.form', $data);
        }
    }
    public function add_barang(Request $request)
    {
        $pembelian = new Pembelian();
        $pembelian->barangId = $request->id_barang;
        if ($request->hargaBaru == null || $request->hargaBaru == 0) {
            $pembelian->harga = $request->hargaBeli;
        } else {
            $pembelian->harga = $request->hargaBaru;
        }
        $pembelian->jumlah = $request->jumlah;
        $pembelian->save();

        return redirect('/pembelian/create')->with((['success' => 'Data Berhasil ditambah']));
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
     * @param  \App\Pembelian  $pembelian
     * @return \Illuminate\Http\Response
     */
    public function show(Pembelian $pembelian)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pembelian  $pembelian
     * @return \Illuminate\Http\Response
     */
    public function edit(Pembelian $pembelian)
    {
        if (!Session::get('login')) {
            return redirect('login');
        } else {
            $pembelian = Pembelian::find($pembelian->penggunaId);
            $data['pembelian'] = $pembelian;
            $data['action'] = 'pembelian/update';
            return view('pembelian.form', $data);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pembelian  $pembelian
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pembelian $pembelian)
    {
        if ($request->radio1 === "Tunai") {
            $status = 1;
            $jatuhtempo = $request->tanggal;
        } else {
            $status = 0;
            $jatuhtempo = $request->jatuhTempo;
        }
        DB::table('pembelian')->where('faktur', 0)
            ->update(['supplierId' => $request->supplierId, 'penggunaId' => session('penggunaId'), 'tanggal' => $request->tanggal, 'metodePembayaran' => $request->radio1, 'keterangan' => $request->keterangan, 'status' => $status, 'jatuhTempo' => $jatuhtempo, 'faktur' => $request->faktur]);

        $jurnalPembelian = new JurnalPembelian();
        $jurnalPembelian->jurnalPembelianTgl = $request->tanggal;
        $jurnalPembelian->faktur =  $request->faktur;
        $jurnalPembelian->debitPersediaan = $request->totalHarga;
        if ($request->radio1 == 'Tunai') {
            $jurnalPembelian->kreditKas = $request->totalHarga;
            $jurnalPembelian->keterangan = "Pembelian Tunai";
        } else {
            $jurnalPembelian->kreditHutang = $request->totalHarga;
            $jurnalPembelian->keterangan = "Pembelian Kredit";
        }
        $jurnalPembelian->save();

        if ($request->radio1 == 'Tunai') {
            $jurnalKasKeluar = new JurnalKasKeluar();
            $jurnalKasKeluar->tanggal = $request->tanggal;
            $jurnalKasKeluar->faktur = "FB-" . $request->faktur;
            $jurnalKasKeluar->debitPersediaan = $request->totalHarga;
            $jurnalKasKeluar->kreditKas = $request->totalHarga;
            $jurnalKasKeluar->save();
        }

        if ($request->radio1 === "Tunai") {
            //Akun Persediaan
            DB::table('saldoPeriode')->where('saldoPeriode.akunId', '=', '1103')->where('periode.aktif', '=', '1')
                ->join('periode', 'periode.periodeId', '=', 'saldoPeriode.periodeId')
                ->increment('saldoPeriode.saldoTotal', $request->totalHarga);

            DB::table('jurnalumum')->insert([
                'tanggal' => $request->tanggal,
                'faktur' => "FB-" . $request->faktur,
                'akun' => '1103',
                'keterangan' => "Pembelian Tunai FB-" . $request->faktur,
                'debit' => $request->totalHarga
            ]);
            //Akun Kas
            DB::table('saldoPeriode')->where('saldoPeriode.akunId', '=', '1101')->where('periode.aktif', '=', '1')
                ->join('periode', 'periode.periodeId', '=', 'saldoPeriode.periodeId')
                ->decrement('saldoPeriode.saldoTotal', $request->totalHarga);

            DB::table('jurnalumum')->insert([
                'tanggal' => $request->tanggal,
                'faktur' => "FB-" . $request->faktur,
                'akun' => '1101',
                'keterangan' => "Pembelian Tunai FB-" . $request->faktur,
                'kredit' => $request->totalHarga
            ]);
        } else {
            //Akun Persediaan
            DB::table('saldoPeriode')->where('saldoPeriode.akunId', '=', '1103')->where('periode.aktif', '=', '1')
                ->join('periode', 'periode.periodeId', '=', 'saldoPeriode.periodeId')
                ->increment('saldoPeriode.saldoTotal', $request->totalHarga);
            DB::table('jurnalumum')->insert([
                'tanggal' => $request->tanggal,
                'faktur' => "FB-" . $request->faktur,
                'akun' => '1103',
                'keterangan' => "Pembelian Kredit FB-" . $request->faktur,
                'debit' => $request->totalHarga
            ]);

            //Akun Piutang
            DB::table('saldoPeriode')->where('saldoPeriode.akunId', '=', '2101')->where('periode.aktif', '=', '1')
                ->join('periode', 'periode.periodeId', '=', 'saldoPeriode.periodeId')
                ->increment('saldoPeriode.saldoTotal', $request->totalHarga);

            DB::table('jurnalumum')->insert([
                'tanggal' => $request->tanggal,
                'faktur' => "FB-" . $request->faktur,
                'akun' => '2101',
                'keterangan' => "Pembelian Kredit FB-" . $request->faktur,
                'kredit' => $request->totalHarga
            ]);
        }


        return redirect('/pembelian')->with((['success' => 'Data berhasil ditambahkan']));
    }
    public function delete($id)
    {
        try {
            $pembelian = Pembelian::find($id);
            $pembelian->delete();
            return redirect('/pembelian/create')->with((['success' => 'Data ' . $pembelian->nama . ' Berhasil dihapus']));
        } catch (QueryException $ex) {
            return redirect('/pembelian/create')->with((['error' => 'Data ' . $pembelian->nama . ' Gagal dihapus karena masih digunakan pada Tabel Lain']));
        }
    }

    public function read_by_faktur($id)
    {
        if (!Session::get('login')) {
            return view('login.login');
        } else {
            $pembelian = DB::select("SELECT b.nama as b_nama, pb.jumlah, pb.harga, pb.status, pb.jatuhTempo FROM pembelian as pb, barang as b WHERE faktur = $id AND b.barangId = pb.barangId");
            $returpembelian = DB::select("SELECT rp.returPembelianId ,b.kode, b.nama, rp.jumlah, rp.harga, s.nama as s_nama, p.nama as p_nama, rp.tanggal from returpembelian rp, barang b, supplier s, pengguna p WHERE rp.supplierId = s.supplierId AND rp.penggunaId = p.penggunaId AND rp.barangId = b.barangId AND rp.faktur = $id AND rp.retur = 1");

            $data['pembelian'] = $pembelian;
            $data['returpembelian'] = $returpembelian;
            $data['faktur'] = $id;
            $data['tahun'] = DB::table('periode')->where('aktif', 1)->max('tahun');
            return view('pembelian.detail', $data);
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pembelian  $pembelian
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pembelian $pembelian)
    {
        //
    }

    public function bayar(Request $request, Pembelian $pembelian)
    {
        DB::table("pembelian")->where('faktur', $request->faktur)
            ->update(['status' => 1]);

        $pembelian = DB::select("SELECT b.nama as b_nama, pb.jumlah as jumlah, pb.harga as harga, pb.status FROM pembelian as pb, barang as b WHERE faktur = $request->faktur AND b.barangId = pb.barangId");
        $totalHarga = 0;
        foreach ($pembelian as $key) {
            $totalHarga += $key->jumlah * $key->harga;
        }
        $jurnalKasKeluar = new JurnalKasKeluar();
        $jurnalKasKeluar->tanggal = $request->tanggal;
        $jurnalKasKeluar->faktur = "FB-" . $request->faktur;
        $jurnalKasKeluar->debitHutangUsaha = $request->totalbayar;
        $jurnalKasKeluar->kreditKas = $request->totalbayar;
        $jurnalKasKeluar->save();

        //Hutang Usaha
        DB::table('jurnalumum')->insert([
            'tanggal' => $request->tanggal,
            'faktur' => "FB-" . $request->faktur,
            'akun' => '2101',
            'keterangan' => "Pelunasan Pembelian Kredit FB-" . $request->faktur,
            'debit' => $request->totalbayar
        ]);

        //kas
        DB::table('jurnalumum')->insert([
            'tanggal' => $request->tanggal,
            'faktur' => "FB-" . $request->faktur,
            'akun' => '1101',
            'keterangan' => "Pelunasan Pembelian Kredit FB-" . $request->faktur,
            'kredit' => $request->totalbayar
        ]);

        $pembelian = DB::select("SELECT s.nama as s_nama,p.nama as p_nama,pb.tanggal,pb.metodePembayaran,pb.keterangan,pb.status,pb.jatuhTempo, sum(pb.harga) as harga, pb.faktur FROM pembelian as pb, supplier as s, pengguna as p WHERE pb.supplierId = s.supplierId AND pb.penggunaId = p.penggunaId GROUP BY pb.faktur");
        $data['pembelian'] = $pembelian;
        $data['tahun'] = DB::table('periode')->where('aktif', 1)->max('tahun');
        return view('pembelian.index', $data);
    }
}
