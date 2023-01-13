@extends('masterform')
@section('title', "Detail Pembelian")
@section('content')
@if ($pembelian[0]->status)
<div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h5><i class="icon fas fa-check"></i>Faktur Pembelian FB-<?php echo $faktur ?> Sudah Lunas</h5>
</div>
@else
<div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h5><i class="icon fas fa-ban"></i>Faktur Pembelian FB-<?php echo $faktur ?> Belum Lunas</h5>
</div>
@endif
<?php $totalretur = 0; ?>
<div class="card">
    <div class="card-header">
        <h5>Pembelian Faktur PB-{{$faktur}} </h5>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <table id="tabel" class="table table-bordered table-hover ">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Barang</th>
                    <th>Jumlah</th>
                    <th>Harga Satuan</th>
                    <th>Total Harga</th>
                </tr>
            </thead>
            <tbody>
                <?php $total = 0; ?>
                @foreach($pembelian as $key => $value)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$value->b_nama}}</td>
                    <td>{{$value->jumlah}} Buah</td>
                    <td><?php echo "Rp ". number_format($value->harga, 0, ',', '.')?></td>
                    <td><?php echo "Rp ". number_format($value->jumlah * $value->harga, 0, ',', '.')?></td>
                    <?php
                    $total += $value->jumlah * $value->harga;
                    ?>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <th colspan=4 style="text-align:center;">
                    Total Harga
                </th>
                <th><?php echo "Rp ". number_format($total, 0, ',', '.')?></th>
            </tfoot>
        </table>
    </div>
    <!-- /.card-body -->
    <div class="card-footer" style="display: inline-flex;position: relative;">
        @if(!$returpembelian)
        <a href="{{ url('pembelian/')}}"><small class="btn btn-primary"><i class="fa fa-arrow-circle-left"></i> Kembali</small></a>
        @if (!$pembelian[0]->status)
        <button type="" data-toggle="modal" data-target="#proses" class="btn btn-primary" style="position: absolute;right: 20px;">Bayar</button>
        @endif
        @endif
    </div>
</div>
<?php if ($returpembelian) { ?>
    <div class="card">
        <div class="card-header">
            <h5>Retur Pembelian Faktur PB-{{$faktur}} </h5>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="tabel" class="table table-bordered table-hover ">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Barang</th>
                        <th>Jumlah</th>
                        <th>Harga Satuan</th>
                        <th>Total Retur</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($returpembelian as $key => $value)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$value->nama}}</td>
                        <td>{{$value->jumlah}}</td>
                        <td><?php echo "Rp ". number_format($value->harga, 0, ',', '.')?></td>
                        <td><?php echo "Rp ". number_format(($value->jumlah * $value->harga), 0, ',', '.')?></td>
                        <?php $totalretur +=  ($value->jumlah * $value->harga); ?>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <th colspan=4 style="text-align:center;">
                        Total Harga
                    </th>
                    <th><?php echo "Rp ". number_format($totalretur, 0, ',', '.')?></th>
                </tfoot>
            </table>
        </div>
        <!-- /.card-body -->
        <div class="card-footer" style="display: inline-flex;position: relative;">
            <a href="{{ url('pembelian/')}}"><small class="btn btn-primary"><i class="fa fa-arrow-circle-left"></i> Kembali</small></a>
            @if (!$pembelian[0]->status)
            <button type="" data-toggle="modal" data-target="#proses" class="btn btn-primary" style="position: absolute;right: 20px;">Bayar</button>
            @endif
        </div>
    </div>
<?php } ?>
<div id="proses" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="icon-menu7"></i> &nbsp;Pembayaran FB-{{$faktur}}</h5>
            </div>
            <form role="form" method="post" action="{{url('pembelian/bayar') }}">
                {{csrf_field()}}
                <input type="hidden" name="faktur" class="form-control" placeholder="" value="<?php echo $faktur ?>">
                <div class="modal-body-logout" style="padding:20px;">
                    <div class="col-sm">
                        <!-- text input -->
                        <div class="form-group">
                            <label>Tanggal Pembayaran</label>
                            <input type="date" class="form-control" placeholder="" value="<?php echo $pembelian[0]->jatuhTempo; ?>" name="tanggal">
                        </div>
                        <div class="form-group">
                            <label>Total Pembayaran</label>
                            <input type="text" class="form-control" placeholder="" value="<?php echo "Rp ". number_format($total -$totalretur, 0, ',', '.')?>" readonly>
                            <input type="hidden" class="form-control" placeholder="" value="<?php echo $total-$totalretur?>" name="totalbayar">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal"><i class="icon-cross"></i> Close</button>
                    <button class="btn btn-primary" type="submit"><i class="icon-switch2"></i> Bayar</button>
                </div>
            </form>

        </div>
    </div>
</div>
</div>
@endsection