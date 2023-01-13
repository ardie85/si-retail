@extends('master')
@section('title', 'Penjualan')
@section('judul','Data Penjualan')
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
    <a href="{{ url('penjualan/create')}}"><small class="btn btn-primary btn-sm"><i class="fa fa-plus"></i>Tambah Data </small></a>

</div>
<!-- /.card-header -->
<!--<div class="card-body">
        <table id="tabel_product" class="table table-bordered table-hover ">
            <thead>
                <tr>
                    <th>No Faktur.</th>
                    <th>Karyawan</th>
                    <th>Tanggal Beli</th>
                    <th>Cara Pembelian</th>
                    <th>Jatuh Tempo</th>
                    <th>Pelanggan</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($penjualan as $key => $value)
                <tr>
                    <td>FJ-{{$key+1}}</td>
                    <td>{{$value->p_nama}}</td>
                    <td>{{$value->tanggal}}</td>
                    <td>{{$value->metodePembayaran}}</td>
                    <td>{{$value->jatuhTempo}}</td>
                    <td>{{$value->c_nama}}</td>
                    <td>{{$value->keterangan}}</td>
                    <td><a href="{{url('penjualan/detail/'.$value->faktur)}}"><i class="nav-icon fa fa-search"></i></a>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>-->
<!-- /.card-body -->
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
                                <th>Pelanggan</th>
                                <th>Keterangan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($penjualan as $key => $value)
                            @if($value->metodePembayaran == "Tunai")
                            <tr>
                                <td>FJ-{{$key+1}}</td>
                                <td>{{$value->p_nama}}</td>
                                <td>{{$value->tanggal}}</td>
                                <td>{{$value->metodePembayaran}}</td>
                                <td>{{$value->c_nama}}</td>
                                <td>{{$value->keterangan}}</td>
                                @if($value->status == 1)
                                <td><span class='label label-success'>Lunas</span></td>
                                @else
                                <td>Belum Lunas</td>
                                @endif
                                <td><a href="{{url('penjualan/detail/'.$value->faktur)}}"><i class="nav-icon fa fa-search"></i></a>
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
                                <th>Pelanggan</th>
                                <th>Keterangan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($penjualan as $key => $value)
                            @if($value->metodePembayaran == "Kredit")
                            <tr>
                                <td>FJ-{{$key+1}}</td>
                                <td>{{$value->p_nama}}</td>
                                <td>{{$value->tanggal}}</td>                                
                                <td>{{$value->jatuhTempo}}</td>
                                <td>{{$value->metodePembayaran}}</td>
                                <td>{{$value->c_nama}}</td>
                                <td>{{$value->keterangan}}</td>
                                @if($value->status == 1)
                                <td><span class='label label-success'>Lunas</span></td>
                                @else
                                <td>Belum Lunas</td>
                                @endif
                                <td><a href="{{url('penjualan/detail/'.$value->faktur)}}"><i class="nav-icon fa fa-search"></i></a>
                                   
                                </td>
                                <!-- <form method="post" action="{{url('penjualan/bayar')}}">
                                    {{csrf_field()}}
                                    <div id="proses" class="modal fade">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title"><i class="icon-menu7"></i> &nbsp;Faktur FJ-{{$value->faktur}}</h5>
                                                </div>
                                                <div class="modal-body-logout" style="padding:20px;">
                                                    <label>Tanggal Pelunasan</label>
                                                    <input type="date" class="form-control" placeholder="" value="<?php echo $tahun . '-01-01'; ?>" name="tanggal">
                                                    <input type="hidden" name="faktur" value="<?php echo $value->faktur ?>">
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-danger" data-dismiss="modal"><i class="icon-cross"></i> Close</button>
                                                    <button class="btn btn-primary" type="submit"><i class="icon-switch2"></i> Bayar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form> -->
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
</div>
@endsection