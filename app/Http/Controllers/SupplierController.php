<?php

namespace App\Http\Controllers;

use App\supplier;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class SupplierController extends Controller
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
            $supplier = Supplier::all();
            $data['supplier'] = $supplier;
            return view('supplier.index', $data);
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
            $data['action'] = 'supplier.store';
            return view('supplier.form', $data);
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
        if (!Session::get('login')) {
            return view('login.login');
        } else {
            $supplier = new Supplier();
            $supplier->nama = $request->nama;
            $supplier->alamat = $request->alamat;
            $supplier->nomorTelp = $request->nomorTelp;
            $supplier->save();

            return redirect('/supplier')->with((['success' => 'Data Berhasil ditambah']));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit(Supplier $supplier)
    {
        if (!Session::get('login')) {
            return redirect('login');
        } else {
            $supplier = Supplier::find($supplier->supplierId);
            $data['supplier'] = $supplier;
            $data['action'] = 'supplier/update';
            return view('supplier.form', $data);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Supplier $supplier)
    {
        $supplier = Supplier::find($request->supplierId);
        $supplier->supplierId = $request->supplierId;
        $supplier->nama = $request->nama;
        $supplier->alamat = $request->alamat;
        $supplier->nomorTelp = $request->nomorTelp;
        $supplier->save();
        return redirect('/supplier')->with((['success' => 'Data berhasil diupdate']));
    }
    public function delete($id)
    {
        if (!Session::get('login')) {
            return view('login.login');
        } else {
            try {
                $supplier = Supplier::find($id);
                $supplier->delete();
                return redirect('/supplier')->with((['success' => 'Data ' . $supplier->nama . ' Berhasil dihapus']));
            } catch (QueryException $ex) {
                return redirect('/supplier')->with((['error' => 'Data ' . $supplier->nama . ' Gagal dihapus karena masih digunakan pada Tabel Lain']));
            }
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supplier $supplier)
    {
        //
    }
}
