@extends('master')
@section('title', 'Beban')
@section('judul','Data Beban')
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
        <a href="{{ url('beban/create')}}"><small class="btn btn-primary btn-sm"><i class="fa fa-plus"></i>Tambah Data </small></a>

    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <table id="tabel_product" class="table table-bordered table-hover ">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Kode Beban</th>
                    <th>Tanggal</th>
                    <th>Nama Beban</th>
                    <th>Nominal</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($beban as $key => $value)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>BB-{{$value->bebanId}}</td>
                    <td>{{$value->tanggal}}</td>
                    <td>{{$value->nama}}</td>
                    <td><?php echo "Rp ". number_format($value->nominal, 0, ',', '.')?></td>
                    <td>{{$value->keterangan}}</td>
                    <!-- <td>
                        <a href="{{url('beban/'.$value->bebanId.'/edit')}}"><i class="nav-icon fa fa-edit"></i></a> | 
                    <a href="{{url('beban/delete/'.$value->bebanId)}}"><i class="nav-icon fa fa-trash"></i></a></td> -->
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
</div>
@endsection