@extends('master')
@section('title', 'Barang')
@section('judul', 'Form Barang')
@section('content')
<form role="form" method="post" action="{{($action!='barang.store') ? url($action): route($action) }}">
    {{csrf_field()}}
    <div class="form-group">
        <input type="hidden" name="barangId" value="{{ ($action!='barang.store') ? $barang->barangId : ''}}">
        <div class="form-group row ">
            <label for="inputName" class="col-sm-2 col-form-label">Kode Barang</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" placeholder="Kode Barang" name="kode" value="{{ ($action!='barang.store') ? $barang->kode : ''}}" required>
            </div>
        </div>
        <div class="form-group row ">
            <label for="inputName" class="col-sm-2 col-form-label">Nama Barang</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" placeholder="Nama Barang" name="nama" value="{{ ($action!='barang.store') ? $barang->nama : ''}}" required>
            </div>
        </div>
        <div class="form-group row ">
            <label for="inputName" class="col-sm-2 col-form-label">Stok</label>
            <div class="col-sm-10">
                <input type="number" class="form-control" placeholder="Stok" name="stok" value="{{ ($action!='barang.store') ? $barang->stok : ''}}" required>
            </div>
        </div>
        <div class="form-group row ">
            <label for="inputName" class="col-sm-2 col-form-label">Harga Beli</label>
            <div class="col-sm-10">
                <input type="text" id="rupiah" class="form-control" data-mask placeholder="Harga Beli" name="hargaBeli" value="{{ ($action!='barang.store') ? $barang->hargaBeli : ''}}">
            </div>
        </div>
        <div class="form-group row ">
            <label for="inputName" class="col-sm-2 col-form-label">Harga Jual</label>
            <div class="col-sm-10">
                <input type="number" class="form-control" placeholder="Harga Jual" name="hargaJual" value="{{ ($action!='barang.store') ? $barang->hargaJual : ''}}" required>
            </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <input type="submit" class="btn btn-primary" value="{{ ($action!='barang.store') ? 'Update' : 'Simpan' }}">
            <button type="reset" class="btn btn-default float-right">Cancel</button>
        </div>
        <!-- /.card-footer -->
    </div>
</form>
@endsection