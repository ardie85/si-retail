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
<div class="card">
    <!-- /.card-header -->
    <div class="card-body">
        <table id="tabel_product" class="table table-bordered table-hover ">
            <thead>
                <tr>
                    <th rowspan="2">Kode</th>
                    <th rowspan="2">Nama</th>
                    <th colspan="2">Saldo Awal</th>
                    <th rowspan="2">Aksi</th>
                </tr>
                <tr>
                    <th>Debit</th>
                    <th>Kredit</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th colspan="5">1 - Aset</th>
                </tr>
                @foreach($akun as $key => $value)
                @if($value->jenis == "Aset")
                <tr>

                    <td>{{$value->akunid}}</td>
                    <td>{{$value->nama}}</td>
                    @if($value->saldoNormal == "Debit")
                    <td><?php echo "Rp ". number_format($value->saldoAwal, 0, ',', '.')?></td>
                    @else
                    <td></td>
                    @endif
                    @if($value->saldoNormal == "Kredit")
                    <td><?php echo "Rp ". number_format($value->saldoAwal, 0, ',', '.')?></td>
                    @else
                    <td></td>
                    @endif
                    @if(!$value->saldoKunci)
                    <td><a href="{{url('akunSaldo/'.$value->saldoId.'/edit')}}"><i class="nav-icon fa fa-edit"></i></a></td>
                    @else
                    <td></td>
                    @endif
                </tr>
                @endif
                @endforeach
                <tr>
                    <th colspan="5">2 - Kewajiban</th>
                </tr>
                @foreach($akun as $key => $value)
                @if($value->jenis == "Kewajiban")
                <tr>

                    <td>{{$value->akunid}}</td>
                    <td>{{$value->nama}}</td>
                    @if($value->saldoNormal == "Debit")
                    <td><?php echo "Rp ". number_format($value->saldoAwal, 0, ',', '.')?></td>
                    @else
                    <td></td>
                    @endif
                    @if($value->saldoNormal == "Kredit")
                    <td><?php echo "Rp ". number_format($value->saldoAwal, 0, ',', '.')?></td>
                    @else
                    <td></td>
                    @endif
                    @if(!$value->saldoKunci)
                    <td><a href="{{url('akunSaldo/'.$value->saldoId.'/edit')}}"><i class="nav-icon fa fa-edit"></i></a></td>
                    @else
                    <td></td>
                    @endif
                </tr>
                @endif
                @endforeach
                <tr>
                    <th colspan="5">3 - Modal</th>
                </tr>
                @foreach($akun as $key => $value)
                @if($value->jenis == "Ekuitas")
                <tr>
                    <td>{{$value->akunid}}</td>
                    <td>{{$value->nama}}</td>
                    @if($value->saldoNormal == "Debit")
                    <td><?php echo "Rp ". number_format($value->saldoAwal, 0, ',', '.')?></td>
                    @else
                    <td></td>
                    @endif
                    @if($value->saldoNormal == "Kredit")
                    <td><?php echo "Rp ". number_format($value->saldoAwal, 0, ',', '.')?></td>
                    @else
                    <td></td>
                    @endif
                    @if(!$value->saldoKunci)
                    <td><a href="{{url('akunSaldo/'.$value->saldoId.'/edit')}}"><i class="nav-icon fa fa-edit"></i></a></td>
                    @else
                    <td></td>
                    @endif
                </tr>
                @endif
                @endforeach
                <tr>
                    <th colspan="5">4 - Penjualan</th>
                </tr>
                @foreach($akun as $key => $value)
                @if($value->jenis == "Penjualan")
                <tr>

                    <td>{{$value->akunid}}</td>
                    <td>{{$value->nama}}</td>
                    @if($value->saldoNormal == "Debit")
                    <td><?php echo "Rp ". number_format($value->saldoAwal, 0, ',', '.')?></td>
                    @else
                    <td></td>
                    @endif
                    @if($value->saldoNormal == "Kredit")
                    <td><?php echo "Rp ". number_format($value->saldoAwal, 0, ',', '.')?></td>
                    @else
                    <td></td>
                    @endif
                    @if(!$value->saldoKunci)
                    <td><a href="{{url('akunSaldo/'.$value->saldoId.'/edit')}}"><i class="nav-icon fa fa-edit"></i></a></td>
                    @else
                    <td></td>
                    @endif
                </tr>
                @endif
                @endforeach
                <tr>
                    <th colspan="5">5 - Harga Pokok Penjualan</th>
                </tr>
                @foreach($akun as $key => $value)
                @if($value->jenis == "HPP")
                <tr>

                    <td>{{$value->akunid}}</td>
                    <td>{{$value->nama}}</td>
                    @if($value->saldoNormal == "Debit")
                    <td><?php echo "Rp ". number_format($value->saldoAwal, 0, ',', '.')?></td>
                    @else
                    <td></td>
                    @endif
                    @if($value->saldoNormal == "Kredit")
                    <td><?php echo "Rp ". number_format($value->saldoAwal, 0, ',', '.')?></td>
                    @else
                    <td></td>
                    @endif
                    @if(!$value->saldoKunci)
                    <td><a href="{{url('akunSaldo/'.$value->saldoId.'/edit')}}"><i class="nav-icon fa fa-edit"></i></a></td>
                    @else
                    <td></td>
                    @endif
                </tr>
                @endif
                @endforeach
                <tr>
                    <th colspan="5">6 - Beban</th>
                </tr>
                @foreach($akun as $key => $value)
                @if($value->jenis == "Beban")
                <tr>

                    <td>{{$value->akunid}}</td>
                    <td>{{$value->nama}}</td>
                    @if($value->saldoNormal == "Debit")
                    <td><?php echo "Rp ". number_format($value->saldoAwal, 0, ',', '.')?></td>
                    @else
                    <td></td>
                    @endif
                    @if($value->saldoNormal == "Kredit")
                    <td><?php echo "Rp ". number_format($value->saldoAwal, 0, ',', '.')?></td>
                    @else
                    <td></td>
                    @endif
                    @if(!$value->saldoKunci)
                    <td><a href="{{url('akunSaldo/'.$value->saldoId.'/edit')}}"><i class="nav-icon fa fa-edit"></i></a></td>
                    @else
                    <td></td>
                    @endif
                </tr>
                @endif
                @endforeach
                <?php
                $totaldebit = 0;
                $totalkredit = 0;
                ?>
                @foreach($akun as $key => $value)
                <?php
                if ($value->saldoNormal == "Debit") {
                    $totaldebit += $value->saldoAwal;
                } else {
                    $totalkredit += $value->saldoAwal;
                }

                ?>
                @endforeach
                <tr>
                    <th colspan="2">Total</th>
                    <th><?php echo "Rp ". number_format($totaldebit, 0, ',', '.')?></th>
                    <th><?php echo "Rp ". number_format($totalkredit, 0, ',', '.')?></th>
                    <th></th>
                </tr>
            </tbody>
        </table>
        @if(!$akun[0]->saldoKunci)
        <div style="text-align: center;">
            <button type="" class="btn btn-danger" data-toggle="modal" data-target="#modal-danger">Kunci Saldo</button>
        </div>
        @endif
    </div>
    <!-- /.card-body -->
</div>
<form method="post" action="{{($action!='akunSaldo.kunci') ? url($action): route($action) }}">
    {{csrf_field()}}
    <div class="modal fade" id="modal-danger" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-danger">
                <div class="modal-header">
                    <h4 class="modal-title">Kunci Saldo Awal?</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h5>Apakah anda yakin untuk mengunci Saldo Awal?</h5><br>
                    <p>Ketika saldo terkunci maka tidak dapat diubah kembali</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-outline-light">Kunci Saldo</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</form>

@endsection