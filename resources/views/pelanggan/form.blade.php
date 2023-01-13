@extends('master')
@section('title', 'Pelanggan')
@section('judul', 'Form Pelanggan')
@section('content')
<form role="form" method="post" action="{{($action!='pelanggan.store') ? url($action): route($action) }}">
    {{csrf_field()}}
    <div class="form-group">
        <input type="hidden" name="pelangganId" value="{{ ($action!='pelanggan.store') ? $pelanggan->pelangganId : ''}}">
        <div class="form-group row ">
            <label for="inputName" class="col-sm-2 col-form-label">Nama Pelanggan</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" placeholder="Nama" name="nama" value="{{ ($action!='pelanggan.store') ? $pelanggan->nama : ''}}">
            </div>
        </div>
        <div class="form-group row ">
            <label for="inputName" class="col-sm-2 col-form-label">Alamat</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" placeholder="Alamat" name="alamat" value="{{ ($action!='pelanggan.store') ? $pelanggan->alamat : ''}}">
            </div>
        </div>
        <div class="form-group row ">
            <label for="inputName" class="col-sm-2 col-form-label">Nomor Telp</label>
            <div class="col-sm-10">
                <input type="number" class="form-control" placeholder="Nomor Telp" name="Nomor Telp" value="{{ ($action!='pelanggan.store') ? $pelanggan->nomorTelp : ''}}">
            </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <input type="submit" class="btn btn-primary" value="{{ ($action!='pelanggan.store') ? 'Update' : 'Simpan' }}">
            <button type="reset" class="btn btn-default float-right">Cancel</button>
        </div>
        <!-- /.card-footer -->
    </div>
</form>
@endsection