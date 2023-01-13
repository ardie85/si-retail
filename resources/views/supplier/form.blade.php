@extends('master')
@section('title', 'Supplier')
@section('judul', 'Form Supplier')
@section('content')
<form role="form" method="post" action="{{($action!='supplier.store') ? url($action): route($action) }}">
    {{csrf_field()}}
    <div class="form-group">
        <input type="hidden" name="supplierId" value="{{ ($action!='supplier.store') ? $supplier->supplierId : ''}}">
        <div class="form-group row ">
            <label for="inputName" class="col-sm-2 col-form-label">Nama Supplier</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" placeholder="Nama" name="nama" value="{{ ($action!='supplier.store') ? $supplier->nama : ''}}">
            </div>
        </div>
        <div class="form-group row ">
            <label for="inputName" class="col-sm-2 col-form-label">Alamat</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" placeholder="Alamat" name="alamat" value="{{ ($action!='supplier.store') ? $supplier->alamat : ''}}">
            </div>
        </div>
        <div class="form-group row ">
            <label for="inputName" class="col-sm-2 col-form-label">Nomor Telp</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" placeholder="Nomor Telp" name="nomorTelp" value="{{ ($action!='supplier.store') ? $supplier->nomorTelp : ''}}">
            </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <input type="submit" class="btn btn-primary" value="{{ ($action!='supplier.store') ? 'Update' : 'Simpan' }}">
            <button type="reset" class="btn btn-default float-right">Cancel</button>
        </div>
        <!-- /.card-footer -->
    </div>
</form>
@endsection