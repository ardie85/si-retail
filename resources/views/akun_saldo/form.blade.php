@extends('master')
@section('title', 'Akun Saldo')
@section('judul', 'Form Akun Saldo')
@section('content')
<form role="form" method="post" action="{{($action!='akunsaldo.store') ? url($action): route($action) }}">
    {{csrf_field()}}
    <div class="form-group">
        <input type="hidden" name="saldoId" value="{{ ($action!='akunsaldo.store') ? $akunSaldo->saldoId : ''}}">
        <div class="form-group row ">
            <label for="inputName" class="col-sm-2 col-form-label">Nama Akun</label>
            <div class="col-sm-10">
                <input type="text" disabled class="form-control" placeholder="ex : Richard Juvanto" name="nama" value="{{ ($action!='akunSaldo.store') ? $akunSaldo->nama : ''}}">
            </div>
        </div>
        <div class="form-group row ">
            <label for="inputName" class="col-sm-2 col-form-label">Saldo Awal</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" placeholder="" name="saldoAwal" value="{{ ($action!='akunSaldo.store') ? $akunSaldo->saldoAwal : ''}}">
            </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <input type="submit" class="btn btn-primary" value="{{ ($action!='akunSaldo.store') ? 'Update' : 'Simpan' }}">
            <button type="reset" class="btn btn-default float-right">Cancel</button>
        </div>
        <!-- /.card-footer -->
    </div>
</form>
@endsection