@extends('master')
@section('title', 'Aset')
@section('judul','Data Aset')
@section('content')
@if ($message = Session::get('success'))
<div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h5><i class="icon fas fa-check"></i> Berhasil!</h5>
    {{$message}}
</div>
@endif
<div class="callout callout-info">
    <h5>Total Aset</h5>
    <p>Total Aset Saat Ini adalah <b><?php echo "Rp " . number_format($nilaiAset, 0, ',', '.')?></b>, Penyusutan Peralatan Saat ini <b><?php echo "Rp " . number_format($penyusutanAsetAktif, 0, ',', '.')?></b></p>
    <p>Penyusutan Aset Per Bulan <b><?php echo "Rp " . number_format($penyusutanPerBulan, 0, ',', '.')?></b></p>
</div>
<div class="card">
    <div class="card-header">
        @if(!$akun[0]->saldoKunci)
        <a href="{{ url('aset/create')}}"><small class="btn btn-primary btn-sm"><i class="fa fa-plus"></i>Tambah Data </small></a>
        @endif
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <table id="tabel_product" class="table table-bordered table-hover ">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama</th>
                    <th>Tanggal Beli</th>
                    <th>Jumlah</th>
                    <th>Harga Satuan</th>
                    <th>Masa Manfaat</th>
                    <th>Penyusutan Per Bulan</th>
                    @if(!$akun[0]->saldoKunci)
                    <th>Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach($aset as $key => $value)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$value->nama}}</td>
                    <td>{{$value->tanggal}}</td>
                    <td>{{$value->jumlah}}</td>
                    <td><?php echo "Rp " . number_format($value->harga, 0, ',', '.') ?></td>
                    <td>{{$value->masaManfaat}} bulan</td>
                    <td><?php echo "Rp " . number_format($value->penyusutan, 0, ',', '.') ?></td>
                    @if(!$akun[0]->saldoKunci)
                    <td><a href="{{url('aset/'.$value->asetId.'/edit')}}"><i class="nav-icon fa fa-edit"></i></a> |
                        <a href="{{url('aset/delete/'.$value->asetId)}}"><i class="nav-icon fa fa-trash"></i></a>
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
</div>
@endsection