@extends('master')
@section('title', 'Supplier')
@section('judul','Data Supplier')
@section('content')
@if ($message = Session::get('success'))
<div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h5><i class="icon fas fa-check"></i> Berhasil!</h5>
    {{$message}}
</div>
@endif
<div class="card">
    <div class="card-header">
        <a href="{{ url('supplier/create')}}"><small class="btn btn-primary btn-sm"><i class="fa fa-plus"></i>Tambah Data </small></a>

    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <table id="tabel_product" class="table table-bordered table-hover ">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>Nomor Telepon</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($supplier as $key => $value)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$value->nama}}</td>
                    <td>{{$value->alamat}}</td>
                    <td>{{$value->nomorTelp}}</td>
                    <td><a href="{{url('supplier/'.$value->supplierId.'/edit')}}"><i class="nav-icon fa fa-edit"></i></a> | 
                    <a href="{{url('supplier/delete/'.$value->supplierId)}}"><i class="nav-icon fa fa-trash"></i></a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
</div>
@endsection