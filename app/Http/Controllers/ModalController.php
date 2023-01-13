<?php

namespace App\Http\Controllers;

use App\Modal;
use DB;
use App\JurnalKasMasuk;
use Illuminate\Http\Request;

class ModalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!\Session::get('login')) {
            return redirect('login');
        } else {
            $data['action'] = 'modal.store';
            $data['tahun'] = DB::table('periode')->where('aktif', 1)->max('tahun');
            return view('modal.index', $data);
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

        DB::table('jurnalumum')->insert([
            'tanggal' => $request->tanggal,
            'akun' => '1101',
            'keterangan' => "Penanaman Modal Usaha-" . $request->faktur,
            'debit' => $request->modal
        ]);
        DB::table('jurnalumum')->insert([
            'tanggal' => $request->tanggal,
            'akun' => '3101',
            'keterangan' => "Penanaman Modal Usaha",
            'kredit' => $request->modal
        ]);
        $jurnalKasMasuk = new JurnalKasMasuk();
        $jurnalKasMasuk->tanggal = $request->tanggal;
        $jurnalKasMasuk->faktur = "FJ-" . $request->faktur;
        $jurnalKasMasuk->kreditModal = $request->modal;
        $jurnalKasMasuk->debitKas = $request->modal;
        $jurnalKasMasuk->save();
        $data['tahun'] = DB::table('periode')->where('aktif', 1)->max('tahun');
        return redirect('/penanaman_modal')->with((['success' => 'Berhasil Menambahkan Modal Sebesar Rp. ' . number_format($request->modal, 0, ',', '.')]));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Modal  $modal
     * @return \Illuminate\Http\Response
     */
    public function show(Modal $modal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Modal  $modal
     * @return \Illuminate\Http\Response
     */
    public function edit(Modal $modal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Modal  $modal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Modal $modal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Modal  $modal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Modal $modal)
    {
        //
    }
}
