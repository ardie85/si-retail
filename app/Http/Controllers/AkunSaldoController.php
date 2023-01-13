<?php

namespace App\Http\Controllers;

use App\akunSaldo;
use App\akun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class AkunSaldoController extends Controller
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
            $akunSaldo = DB::table('saldoperiode')
                ->join('akun', 'akun.akunid', '=', 'saldoperiode.akunid')
                ->join('periode', 'periode.periodeid', '=', 'saldoperiode.periodeid')
                ->select('saldoperiode.*', 'akun.*', 'periode.tahun')
                ->orderBy('akun.akunid')
                ->where('periode.aktif', '=', 1)
                ->get();
            $data['akun'] = $akunSaldo;
            $data['action'] = 'akunSaldo/kunci';
            return view('akun_saldo.index', $data);
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
     * @param  \App\akunSaldo  $akunSaldo
     * @return \Illuminate\Http\Response
     */
    public function show(akunSaldo $akunSaldo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\akunSaldo  $akunSaldo
     * @return \Illuminate\Http\Response
     */
    public function edit(akunSaldo $akunSaldo)
    {
        if (!Session::get('login')) {
            return redirect('login');
        } else {
            $akunSaldo = DB::table('saldoperiode')
                ->join('akun', 'akun.akunid', '=', 'saldoperiode.akunid')
                ->join('periode', 'periode.periodeid', '=', 'saldoperiode.periodeid')
                ->select('saldoperiode.*', 'akun.*', 'periode.tahun')
                ->where('saldoperiode.saldoId', '=', $akunSaldo->saldoId)
                ->first();
            $data['akunSaldo'] = $akunSaldo;
            $data['action'] = 'akunSaldo/update';
            return view('akun_saldo.form', $data);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\akunSaldo  $akunSaldo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, akunSaldo $akunSaldo)
    {
        $akunSaldo = AkunSaldo::find($request->saldoId);
        $akunSaldo->saldoAwal = $request->saldoAwal;
        $akunSaldo->saldoTotal = $request->saldoAwal;
        $akunSaldo->save();
        return redirect('/akunSaldo')->with((['success' => 'Data berhasil diupdate']));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\akunSaldo  $akunSaldo
     * @return \Illuminate\Http\Response
     */
    public function destroy(akunSaldo $akunSaldo)
    {
        //
    }

    public function kunci()
    {
        if (!Session::get('login')) {

            return view('login.login');
        } else {
            DB::table('saldoperiode')
                ->update(['saldoKunci' => 1]);
            return redirect('/akunSaldo')->with((['success' => 'Saldo Berhasil Dikunci']));
        }
    }
}
