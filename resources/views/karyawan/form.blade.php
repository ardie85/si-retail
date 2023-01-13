@extends('master')
@section('title', 'Karyawan')
@section('judul', 'Form Karyawan')
@section('content')
<form role="form" method="post" action="{{($action!='karyawan.store') ? url($action): route($action) }}">
    {{csrf_field()}}
    <div class="form-group">
        <input type="hidden" name="penggunaId" value="{{ ($action!='karyawan.store') ? $karyawan->penggunaId : ''}}">
        <div class="form-group row ">
            <label for="inputName" class="col-sm-2 col-form-label">Nama Karyawan</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" placeholder="Nama" name="nama" value="{{ ($action!='karyawan.store') ? $karyawan->nama : ''}}">
            </div>
        </div>
        <div class="form-group row ">
            <label for="inputName" class="col-sm-2 col-form-label">Username</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" placeholder="username" name="username" value="{{ ($action!='karyawan.store') ? $karyawan->username : ''}}">
            </div>
        </div>
        <div class="form-group row ">
            <label for="inputName" class="col-sm-2 col-form-label">Password</label>
            <div class="col-sm-10">
                <input type="password" class="form-control" placeholder="password" name="password" value="{{ ($action!='karyawan.store') ? $karyawan->password : ''}}">
            </div>
        </div>
        <div class="form-group row ">
            <label for="inputName" class="col-sm-2 col-form-label">Alamat</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" placeholder="Alamat" name="alamat" value="{{ ($action!='karyawan.store') ? $karyawan->alamat : ''}}">
            </div>
        </div>
        <div class="form-group row ">
            <label for="inputName" class="col-sm-2 col-form-label">Nomor Telp</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" placeholder="Nomor Telp" name="Nomor Telp" value="{{ ($action!='karyawan.store') ? $karyawan->nomorTelp : ''}}">
            </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <input type="submit" class="btn btn-primary" value="{{ ($action!='karyawan.store') ? 'Update' : 'Simpan' }}">
            <button type="reset" class="btn btn-default float-right">Cancel</button>
        </div>
        <!-- /.card-footer -->
    </div>
</form>
@endsection