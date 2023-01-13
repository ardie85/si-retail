@extends('master')
@section('title', 'Pembelian')
@section('judul','Data Pembelian')
@section('content')
@if ($message = Session::get('success'))
<div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h5><i class="icon fas fa-check"></i> Berhasil!</h5>
    {{$message}}
</div>
@endif
<!--<div class="card">-->
<div class="card-header">
    <a href="{{ url('pembelian/create')}}"><small class="btn btn-primary btn-sm"><i class="fa fa-plus"></i>Tambah Data </small></a>

</div>
<div class="col-12 col-sm">
    <div class="card card-primary card-outline card-tabs">
        <div class="card-header p-0 pt-1 border-bottom-0">
            <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-three-tunai-tab" data-toggle="pill" href="#custom-tabs-three-tunai" role="tab" aria-controls="custom-tabs-three-tunai" aria-selected="true">Tunai</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-three-kredit-tab" data-toggle="pill" href="#custom-tabs-three-kredit" role="tab" aria-controls="custom-tabs-three-kredit" aria-selected="false">Kredit</a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="custom-tabs-three-tabContent">
                <div class="tab-pane fade show active" id="custom-tabs-three-tunai" role="tabpanel" aria-labelledby="custom-tabs-three-tunai-tab">
                    <table id="tabel_debit" class="table table-bordered table-hover ">
                        <thead>
                            <tr>
                                <th>No Faktur.</th>
                                <th>Karyawan</th>
                                <th>Tanggal Beli</th>
                                <th>Cara Pembelian</th>
                                <th>Supplier</th>
                                <th>Keterangan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pembelian as $key => $value)
                            @if($value->metodePembayaran == "Tunai")
                            <tr>
                                <td>FB-{{$key+1}}</td>
                                <td>{{$value->p_nama}}</td>
                                <td>{{$value->tanggal}}</td>
                                <td>{{$value->metodePembayaran}}</td>
                                <td>{{$value->s_nama}}</td>
                                <td>{{$value->keterangan}}</td>
                                @if($value->status == 1)
                                <td><span class='label label-success'>Lunas</span></td>
                                @else
                                <td>Belum Lunas</td>
                                @endif
                                <td><a href="{{url('pembelian/detail/'.$value->faktur)}}"><i class="nav-icon fa fa-search"></i></a>
                                </td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade" id="custom-tabs-three-kredit" role="tabpanel" aria-labelledby="custom-tabs-three-kredit-tab">
                    <table id="tabel_kredit" class="table table-bordered table-hover ">
                        <thead>
                            <tr>
                                <th>No Faktur.</th>
                                <th>Karyawan</th>
                                <th>Tanggal Beli</th>
                                <th>Jatuh Tempo</th>
                                <th>Cara Pembelian</th>
                                <th>Supplier</th>
                                <th>Keterangan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pembelian as $key => $value)
                            @if($value->metodePembayaran == "Kredit")
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$value->p_nama}}</td>
                                <td>{{$value->tanggal}}</td>
                                <td>{{$value->jatuhTempo}}</td>
                                <td>{{$value->metodePembayaran}}</td>
                                <td>{{$value->s_nama}}</td>
                                <td>{{$value->keterangan}}</td>
                                @if($value->status == 1)
                                <td><span class='label label-success'>Lunas</span></td>
                                @else
                                <td>Belum Lunas</td>
                                @endif
                                <td><a href="{{url('pembelian/detail/'.$value->faktur)}}"><i class="nav-icon fa fa-search"></i></a>
                                   
                            </tr>
                            @endif
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
        <!-- /.card -->
    </div>
</div>

@endsection