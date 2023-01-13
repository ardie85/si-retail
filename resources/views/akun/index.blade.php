@extends('master')
@section('title', 'Akun')
@section('judul','Daftar Akun')
@section('content')
@if ($message = Session::get('error'))
<div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h5><i class="icon fas fa-ban"></i> Alert!</h5>
    {{$message}}
</div>
@endif
@if ($message = Session::get('success'))
<div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h5><i class="icon fas fa-check"></i> Berhasil!</h5>
    {{$message}}
</div>
@endif
@if($periode == null)
<?php
$startYear = date('Y');
$endYear = $startYear - 10;
$yearArray = range($startYear, $endYear);
?>
<div class="modal show" id="modal-default" style="display: block; padding-right: 16px;background-color: rgba(0,0,0, 0.8);" aria-modal="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tahun Periode</h4>
            </div>
            <div class="modal-body">
                <form role="form" method="post" action="{{($action!='akun.add_periode') ? url($action): route($action) }}">
                    {{csrf_field()}}
                    <div class="form-group">
                        <div class="col-sm">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Tahun</label>
                                <select name="tahun" class="form-control" required>
                                    <option value="">Pilih Tahun</option>
                                    <?php
                                    foreach ($yearArray as $year) {
                                        // this allows you to select a particular year
                                        echo '<option value="' . $year . '">' . $year . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <input type="submit" class="btn btn-primary">
                        </div>
                        <!-- /.card-footer -->
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
@endif
<div class="card">
    <div class="card-header">
        <!--<a href="{{ url('akun/create')}}"><small class="btn btn-primary btn-sm"><i class="fa fa-plus"></i>Tambah Akun </small></a>-->
        @if(!$akunSaldo)
        <button type="" data-toggle="modal" data-target="#create" class="btn btn-primary"><i class="fa fa-plus">Tambah Akun</i></button>
        @endif
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <table id="tabel_product" class="table table-bordered table-hover ">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Saldo Normal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <th colspan="4">1 - Aset</th>
                @foreach($akun as $key => $value)
                @if($value->jenis == "Aset")
                <tr>

                    <td>{{$value->akunid}}</td>
                    <td>{{$value->nama}}</td>
                    <td>{{$value->saldoNormal}}</td>
                    @if(!$value->kunci && !$akunSaldo)
                    <td><a href="{{url('akun/delete/'.$value->akunid)}}"><i class="nav-icon fa fa-trash"></i></a></td>
                    @else
                    <td></td>
                    @endif
                </tr>
                @endif
                @endforeach
                <th colspan="4">2 - Kewajiban</th>
                @foreach($akun as $key => $value)
                @if($value->jenis == "Kewajiban")
                <tr>

                    <td>{{$value->akunid}}</td>
                    <td>{{$value->nama}}</td>
                    <td>{{$value->saldoNormal}}</td>
                    @if(!$value->kunci && !$akunSaldo)
                    <td><a href="{{url('akun/delete/'.$value->akunid)}}"><i class="nav-icon fa fa-trash"></i></a></td>
                    @else
                    <td></td>
                    @endif
                </tr>
                @endif
                @endforeach
                <th colspan="4">3 - Modal</th>
                @foreach($akun as $key => $value)
                @if($value->jenis == "Ekuitas")
                <tr>

                    <td>{{$value->akunid}}</td>
                    <td>{{$value->nama}}</td>
                    <td>{{$value->saldoNormal}}</td>
                    @if(!$value->kunci && !$akunSaldo)
                    <td><a href="{{url('akun/delete/'.$value->akunid)}}"><i class="nav-icon fa fa-trash"></i></a></td>
                    @else
                    <td></td>
                    @endif
                </tr>
                @endif
                @endforeach
                <th colspan="4">4 - Penjualan</th>
                @foreach($akun as $key => $value)
                @if($value->jenis == "Penjualan")
                <tr>

                    <td>{{$value->akunid}}</td>
                    <td>{{$value->nama}}</td>
                    <td>{{$value->saldoNormal}}</td>
                    @if(!$value->kunci && !$akunSaldo)
                    <td><a href="{{url('akun/delete/'.$value->akunid)}}"><i class="nav-icon fa fa-trash"></i></a></td>
                    @else
                    <td></td>
                    @endif
                </tr>
                @endif
                @endforeach
                <th colspan="4">5 - Harga Pokok Penjualan</th>
                @foreach($akun as $key => $value)
                @if($value->jenis == "HPP")
                <tr>

                    <td>{{$value->akunid}}</td>
                    <td>{{$value->nama}}</td>
                    <td>{{$value->saldoNormal}}</td>
                    @if(!$value->kunci && !$akunSaldo)
                    <td><a href="{{url('akun/delete/'.$value->akunid)}}"><i class="nav-icon fa fa-trash"></i></a></td>
                    @else
                    <td></td>
                    @endif
                </tr>
                @endif
                @endforeach
                <th colspan="4">6 - Beban</th>
                @foreach($akun as $key => $value)
                @if($value->jenis == "Beban")
                <tr>

                    <td>{{$value->akunid}}</td>
                    <td>{{$value->nama}}</td>
                    <td>{{$value->saldoNormal}}</td>
                    @if(!$value->kunci && !$akunSaldo)
                    <td><a href="{{url('akun/delete/'.$value->akunid)}}"><i class="nav-icon fa fa-trash"></i></a></td>
                    @else
                    <td></td>
                    @endif
                </tr>
                @endif
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
    <!-- Modal Create-->
    <form method="post" action="{{($action2!='akun.add_akun') ? url($action2): route($action2) }}">
        {{csrf_field()}}
        <div id="create" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="icon-menu7"></i> &nbsp;Form Data</h5>
                    </div>

                    <div class="modal-body-logout" style="padding:20px;">
                        <div class="form-group">
                            <div class="form-group">
                                <label class="col-sm col-form-label">Nama Akun</label>
                                    <div class="col-sm">
                                        <input type="text" class="form-control" name="nama">
                                    </div>
                            </div>
                            <div class="form-group">
                                <label for="inputName" class="col-sm col-form-label">Kategori Akun</label>
                                <div class="col-sm">
                                    <select name="akunid" class="select-size-lg form-control" required>
                                        <option value="">Pilih : </option>
                                        <option value="11">Aset Lancar</option>
                                        <option value="12">Aset Tetap</option>
                                        <option value="21">Kewajiban</option>
                                        <option value="31">Modal</option>
                                        <option value="41">Penjualan</option>
                                        <option value="51">Beban</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputSaldo" class="col-sm col-form-label">Saldo Normal</label>
                                <div class="col-sm">
                                    <select name="saldoNormal" class="select-size-lg form-control" required>
                                        <option value="">Pilih : </option>
                                        <option value="Debit">Debit</option>
                                        <option value="Kredit">Kredit</option>
                                    </select>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-primary">
                        <button class="btn btn-danger" data-dismiss="modal"><i class="icon-cross"></i> Close</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection