<?php

namespace App\Http\Controllers;

use App\Beban;
use Illuminate\Http\Request;
use App\JurnalKasKeluar;
use Illuminate\Support\Facades\Session;
use DB;

class BebanController extends Controller
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
            $beban = Beban::all();
            $data['beban'] = $beban;
            return view('beban.index', $data);
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
            $akunbeban = DB::table('akun')
                ->select('*')
                ->where('akun.jenis', '=', 'Beban')
                ->get();
            $data['akunbeban'] = $akunbeban;
            if (DB::table('beban')->max('faktur') == null) {
                $data['faktur'] = 0;
            } else {
                $data['faktur'] = DB::table('beban')->max('faktur');
            }
            $data['tahun'] = DB::table('periode')->where('aktif', 1)->max('tahun');
            $data['action'] = 'beban.store';
            return view('beban.form', $data);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $beban = new Beban();
        $beban->nama = $request->nama;
        $beban->tanggal = $request->tanggal;
        $beban->nominal = $request->nominal;
        $beban->keterangan = $request->keterangan;
        $beban->faktur = $request->faktur;
        $beban->save();



        if ($request->nama === "Beban Penyusutan Peralatan") {
            //Akun Beban
            DB::table('saldoPeriode')->where('akun.nama', '=', $request->nama)->where('periode.aktif', '=', '1')
                ->join('periode', 'periode.periodeId', '=', 'saldoPeriode.periodeId')
                ->join('akun', 'akun.akunId', '=', 'saldoPeriode.akunId')
                ->increment('saldoPeriode.saldoTotal', $request->nominal);
            $akun = DB::table('akun')->where('nama', '=', $request->nama)->value('akunid');

            //Akun Akumulasi Peralatan
            DB::table('saldoPeriode')->where('saldoPeriode.akunId', '=', '1202')->where('periode.aktif', '=', '1')
                ->join('periode', 'periode.periodeId', '=', 'saldoPeriode.periodeId')
                ->increment('saldoPeriode.saldoTotal', $request->nominal);

            //Jurnal Penyesuaian
            DB::table('jurnalPenyesuaian')->insert([
                'tanggal' => $request->tanggal,
                'bebanId' => $request->faktur,
                'keterangan' => "Beban Penyusutan Peralatan",
                'akun' => 6104,
                'debit' => $request->nominal
            ]);

            DB::table('jurnalPenyesuaian')->insert([
                'tanggal' => $request->tanggal,
                'bebanId' => $request->faktur,
                'keterangan' => "Akumulasi Penyusutan Peralatan",
                'akun' => 1202,
                'kredit' => $request->nominal
            ]);
        } elseif ($request->nama === "Beban Penyusutan Gedung") {
            //Akun Beban
            DB::table('saldoPeriode')->where('akun.nama', '=', $request->nama)->where('periode.aktif', '=', '1')
                ->join('periode', 'periode.periodeId', '=', 'saldoPeriode.periodeId')
                ->join('akun', 'akun.akunId', '=', 'saldoPeriode.akunId')
                ->increment('saldoPeriode.saldoTotal', $request->nominal);
            $akun = DB::table('akun')->where('nama', '=', $request->nama)->value('akunid');

            //Akun Akumulasi Penyusutan Gedung
            DB::table('saldoPeriode')->where('saldoPeriode.akunId', '=', '1204')->where('periode.aktif', '=', '1')
                ->join('periode', 'periode.periodeId', '=', 'saldoPeriode.periodeId')
                ->increment('saldoPeriode.saldoTotal', $request->nominal);

            //Jurnal Penyesuaian
            DB::table('jurnalPenyesuaian')->insert([
                'tanggal' => $request->tanggal,
                'bebanId' => $request->faktur,
                'akun' => 6105,
                'keterangan' => "Beban Penyusutan Gedung",
                'debit' => $request->nominal
            ]);

            DB::table('jurnalPenyesuaian')->insert([
                'tanggal' => $request->tanggal,
                'bebanId' => $request->faktur,
                'akun'=> 1204,
                'keterangan' => "Akumulasi Penyusutan Gedung",
                'kredit' => $request->nominal
            ]);
        } else {
            $jurnalKasKeluar = new JurnalKasKeluar();
            $jurnalKasKeluar->faktur = "BB-" . $request->faktur;
            $jurnalKasKeluar->tanggal = $request->tanggal;
            $jurnalKasKeluar->kreditKas = $request->nominal;
            $jurnalKasKeluar->debitBeban = $request->nominal;
            $jurnalKasKeluar->save();
            //Akun Beban
            DB::table('saldoPeriode')->where('akun.nama', '=', $request->nama)->where('periode.aktif', '=', '1')
                ->join('periode', 'periode.periodeId', '=', 'saldoPeriode.periodeId')
                ->join('akun', 'akun.akunId', '=', 'saldoPeriode.akunId')
                ->increment('saldoPeriode.saldoTotal', $request->nominal);

            $akun = DB::table('akun')->where('nama', '=', $request->nama)->value('akunid');

            DB::table('jurnalumum')->insert([
                'tanggal' => $request->tanggal,
                'faktur' => "BB-" . $request->faktur,
                'akun' => $akun,
                'keterangan' => "Pembayaran Beban BB-" . $request->faktur,
                'debit' => $request->nominal
            ]);


            //Akun Kas
            DB::table('saldoPeriode')->where('saldoPeriode.akunId', '=', '1101')->where('periode.aktif', '=', '1')
                ->join('periode', 'periode.periodeId', '=', 'saldoPeriode.periodeId')
                ->decrement('saldoPeriode.saldoTotal', $request->nominal);

            DB::table('jurnalumum')->insert([
                'tanggal' => $request->tanggal,
                'faktur' => "BB-" . $request->faktur,
                'akun' => '1101',
                'keterangan' => "Pembayaran Beban BB-" . $request->faktur,
                'kredit' => $request->nominal
            ]);
        }

        return redirect('/beban')->with((['success' => 'Data Berhasil ditambah']));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Beban  $beban
     * @return \Illuminate\Http\Response
     */
    public function show(Beban $beban)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Beban  $beban
     * @return \Illuminate\Http\Response
     */
    public function edit(Beban $beban)
    {
        if (!Session::get('login')) {
            return redirect('login');
        } else {
            $beban = Beban::find($beban->bebanId);
            $akunbeban = DB::table('akun')
                ->select('*')
                ->where('akun.jenis', '=', 'Beban')
                ->get();
            $data['akunbeban'] = $akunbeban;
            $data['beban'] = $beban;
            $data['action'] = 'beban/update';
            return view('beban.form', $data);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Beban  $beban
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Beban $beban)
    {
        $beban = Beban::find($request->bebanId);
        $beban->bebanId = $request->bebanId;
        $beban->nama = $request->nama;
        $beban->tanggal = $request->tanggal;
        $beban->nominal = $request->nominal;
        $beban->keterangan = $request->keterangan;
        $beban->save();
        return redirect('/beban')->with((['success' => 'Data berhasil diupdate']));
    }
    public function delete($id)
    {
        if (!Session::get('login')) {
            return view('login.login');
        } else {
            try {
                $beban = Beban::find($id);
                $beban->delete();
                return redirect('/beban')->with((['success' => 'Data ' . $beban->nama . ' Berhasil dihapus']));
            } catch (QueryException $ex) {
                return redirect('/beban')->with((['error' => 'Data ' . $beban->nama . ' Gagal dihapus karena masih digunakan pada Tabel Lain']));
            }
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Beban  $beban
     * @return \Illuminate\Http\Response
     */
    public function destroy(Beban $beban)
    {
        //
    }
}
