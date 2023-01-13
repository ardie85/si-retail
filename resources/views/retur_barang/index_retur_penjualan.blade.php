@extends('master')
@section('title', 'Retur Penjualan')
@section('judul', 'Form Retur Penjualan')
@section('content')
<form role="form" method="post" id="form_id_rj">
    {{csrf_field()}}
    <div class="form-group row ">
        <label for="inputName" class="col-sm-2 col-form-label">Faktur Penjualan</label>
        <select class="form-control select2bs4" name="faktur" style="width: 100%;" id="fakturjual" required>
            <option value="">Pilih Faktur</option>
            @foreach($retur as $key => $value)
            <option value='<?php echo $value->faktur ?>'>FJ-{{$value->faktur}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group row ">
        <input type="submit" class="btn btn-primary" value="Retur Barang">
    </div>
</form>

<div class="card" style="margin-top: 50px;">
    <div class="card-header">
        <h5>Data Retur Penjualan</h5>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <table id="tabel_product" class="table table-bordered table-hover ">
            <thead>
                <tr>
                    <th>No Faktur</th>
                    <th>Karyawan</th>
                    <th>Tanggal Retur</th>
                    <th>Keterangan</th>
                    <th>Pelanggan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($dataReturAll as $key => $value)
                <tr>
                    <td>FJ-{{$value->faktur}}</td>
                    <td>{{$value->p_nama}}</td>
                    <td>{{$value->tanggal}}</td>
                    <td>{{$value->keterangan}}</td>
                    <td>{{$value->c_nama}}</td>
                    <td><a href="{{url('retur_penjualan/detail/'.$value->faktur)}}"><i class="nav-icon fa fa-search"></i></a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
</div>
@endsection