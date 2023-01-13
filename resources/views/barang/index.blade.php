@extends('master')
@section('title', 'Barang')
@section('judul','Data Barang')
@section('content')
@if ($message = Session::get('success'))
<div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h5><i class="icon fas fa-check"></i> Berhasil!</h5>
    {{$message}}
</div>
@endif
<div class="callout callout-info">
    <h5>Total Persediaan Barang</h5>
    <p>Total Persediaan Barang Saat Ini adalah <b><?php echo "Rp " . number_format($nilaiPersediaan, 0, ',', '.') ?></b></p>
</div>
<div class="card">
    <div class="card-header">
        <a href="{{ url('barang/create')}}"><small class="btn btn-primary btn-sm"><i class="fa fa-plus"></i>Tambah Data </small></a>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <table id="tabel_product" class="table table-bordered table-hover ">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Kode Barang</th>
                    <th>Nama</th>
                    <th>Stok</th>
                    <th>Harga Beli</th>
                    <th>Harga Jual</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($barang as $key => $value)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$value->kode}}</td>
                    <td>{{$value->nama}}</td>
                    <td>{{$value->stok}}</td>
                    <td><?php echo "Rp " . number_format($value->hargaBeli, 0, ',', '.') ?></td>
                    <td><?php echo "Rp " . number_format($value->hargaJual, 0, ',', '.') ?></td>
                    <td><a href="{{url('barang/'.$value->barangId.'/edit')}}"><i class="nav-icon fa fa-edit"></i></a> |
                        <a href="{{url('barang/delete/'.$value->barangId)}}"><i class="nav-icon fa fa-trash"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
</div>
@endsection