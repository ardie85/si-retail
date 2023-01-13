@extends('master')
@section('title', 'Aset')
@section('judul', 'Form Aset')
@section('content')
<form role="form" method="post" action="{{($action!='aset.store') ? url($action): route($action) }}">
    {{csrf_field()}}
    <div class="form-group">
        <input type="hidden" name="asetId" value="{{ ($action!='aset.store') ? $aset->asetId : ''}}">
        </div>
        <div class="form-group row ">
            <label for="inputName" class="col-sm-2 col-form-label">Nama Aset</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" placeholder="Nama Aset" name="nama" value="{{ ($action!='aset.store') ? $aset->nama : ''}}" required>
            </div>
        </div>
        <div class="form-group row ">
            <label for="inputName" class="col-sm-2 col-form-label">Tanggal</label>
            <div class="col-sm-10">
                <input type="date" class="form-control" placeholder="Tanggal" name="tanggal" value="{{ ($action!='aset.store') ? $aset->tanggal : $tahun.'-01-01'}}" required>
            </div>
        </div>
        <div class="form-group row ">
            <label for="inputName" class="col-sm-2 col-form-label">Jumlah</label>
            <div class="col-sm-10">
                <input type="number" class="form-control" placeholder="Jumlah" name="jumlah" value="{{ ($action!='aset.store') ? $aset->jumlah : '' }}" required>
            </div>
        </div>
        <div class="form-group row ">
            <label for="inputName" class="col-sm-2 col-form-label">Harga Beli</label>
            <div class="col-sm-10">
                <input type="number" class="form-control" placeholder="Harga Beli" name="harga" value="{{ ($action!='aset.store') ? $aset->harga : ''}}" required>
            </div>
        </div>
        <div class="form-group row ">
            <label for="inputName" class="col-sm-2 col-form-label">Masa Manfaat (Bulan)</label>
            <div class="col-sm-10">
                <input type="number" class="form-control" placeholder="Masa Manfaat" name="masaManfaat" value="{{ ($action!='aset.store') ? $aset->masaManfaat : ''}}" required>
            </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <input type="submit" class="btn btn-primary" value="{{ ($action!='aset.store') ? 'Update' : 'Simpan' }}">
            <button type="reset" class="btn btn-default float-right">Cancel</button>
        </div>
        <!-- /.card-footer -->
    </div>
</form>
@endsection