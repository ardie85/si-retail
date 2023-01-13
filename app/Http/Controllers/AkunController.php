<?php

namespace App\Http\Controllers;

use App\akun;
use App\Periode;
use DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class AkunController extends Controller
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
            if(Session::get('jenis') === "Karyawan"){
                return redirect('penjualan');
            }else{
                $akun = Akun::all();
                $periode = DB::select("SELECT * FROM periode where aktif=1");
                $data['akun'] = $akun;
                $data['action'] = 'akun/add_periode';
                $data['action2'] = 'akun/add_akun';
                $data['periode'] = $periode;
                $akunSaldo = DB::table('saldoperiode')
                    ->join('akun', 'akun.akunid', '=', 'saldoperiode.akunid')
                    ->join('periode', 'periode.periodeid', '=', 'saldoperiode.periodeid')
                    ->select('*')
                    ->orderBy('akun.akunid')
                    ->where('periode.aktif', '=', 1)
                    ->where('saldoperiode.saldoKunci', '=', 1)
                    ->count('*');
                $data['akunSaldo'] = $akunSaldo;
                return view('akun.index', $data);
            }
            
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

            return view('login.login');
        } else {
            $data['action'] = "akun.store";
            return view('akun.form', $data);
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
        $akun = new Akun();
        $akun->nama = $request->nama;
        //$akunid = DB::select("SELECT max(akunid)+1 as akunidmax from akun WHERE akunid LIKE '$request->akunid%'");
        if ($request->akunId == 11) {
            $akunid = DB::table('akun')->where('akunid', 'like', '11%')->max('akunid');
            $akun->jenis = "Aset";
        } elseif ($request->akunId == 12) {
            $akunid = DB::table('akun')->where('akunid', 'like', '12%')->max('akunid');
            $akun->jenis = "Aset";
        } elseif ($request->akunId == 21) {
            $akunid = DB::table('akun')->where('akunid', 'like', '21%')->max('akunid');
            $akun->jenis = "Kewajiban";
        } elseif ($request->akunId == 31) {
            $akunid = DB::table('akun')->where('akunid', 'like', '31%')->max('akunid');
            $akun->jenis = "Ekuitas";
        } elseif ($request->akunId == 41) {
            $akunid = DB::table('akun')->where('akunid', 'like', '41%')->max('akunid');
            $akun->jenis = "Penjualan";
        } else {
            $akunid = DB::table('akun')->where('akunid', 'like', '61%')->max('akunid');
            $akun->jenis = "Beban";
        }
        $akun->akunid = $akunid + 1;
        $akun->saldoNormal = $request->saldoNormal;
        $akun->save();
        return redirect('akun');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\akun  $akun
     * @return \Illuminate\Http\Response
     */
    public function show(akun $akun)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\akun  $akun
     * @return \Illuminate\Http\Response
     */
    public function edit(akun $akun)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\akun  $akun
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, akun $akun)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\akun  $akun
     * @return \Illuminate\Http\Response
     */
    public function destroy(akun $akun)
    {
        //
    }

    public function add_periode(Request $request)
    {
        if (!Session::get('login')) {

            return view('login.login');
        } else {
            $periode = new Periode();
            $periode->tahun = $request->tahun;
            $periode->save();
        }

        return redirect('/akun');
    }
    public function delete($id)
    {
        if (!Session::get('login')) {
            return view('login.login');
        } else {
            try {
                $akun = Akun::find($id);
                $akun->delete();
                return redirect('/akun')->with((['success' => 'Data ' . $akun->nama . ' Berhasil dihapus']));
            } catch (QueryException $ex) {
                return redirect('/akun')->with((['error' => 'Data ' . $akun->nama . ' Gagal dihapus karena masih digunakan pada Tabel Lain']));
            }
        }
    }
}
