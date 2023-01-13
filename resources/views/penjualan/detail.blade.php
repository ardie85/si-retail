@extends('masterform')
@section('title', "Detail Penjualan")
@section('content')
@if ($penjualan[0]->status)
<div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h5><i class="icon fas fa-check"></i>Faktur Penjualan FJ-<?php echo $faktur ?> Sudah Lunas</h5>
</div>
@else
<div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h5><i class="icon fas fa-ban"></i>Faktur Penjualan FJ-<?php echo $faktur ?> Belum Lunas</h5>
</div>
@endif
<div class="card">
    <div class="card-header">
        <h5>Penjualan Faktur FJ-{{$faktur}} </h5>
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
                    <th>Diskon</th>
                    <th>Total Harga</th>
                </tr>
            </thead>
            <tbody>
                <?php $total = 0; $retur = 0?>
                @foreach($penjualan as $key => $value)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$value->b_nama}}</td>
                    <td>{{$value->jumlah}} Buah</td>
                    <td><?php echo "Rp ". number_format($value->harga, 0, ',', '.')?></td>
                    <td><?php echo "Rp ". number_format($value->diskon, 0, ',', '.')?></td>
                    <td><?php echo "Rp ". number_format(($value->harga * $value->jumlah) - $value->diskon, 0, ',', '.')?></td>
                    <?php
                    $total += $value->jumlah * $value->harga - $value->diskon;
                    ?>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <th colspan=5 style="text-align:center;">
                    Total Harga
                </th>
                <th><?php echo "Rp ". number_format($total, 0, ',', '.')?></th>
            </tfoot>
        </table>
    </div>
    <!-- /.card-body -->
    <div class="card-footer" style="display: inline-flex;position: relative;">
        @if(!$returpenjualan)
        <a href="{{ url('penjualan/')}}"><small class="btn btn-primary"><i class="fa fa-arrow-circle-left"></i> Kembali</small></a>
        @if (!$penjualan[0]->status)
        <button type="" data-toggle="modal" data-target="#proses" class="btn btn-primary" style="position: absolute;right: 20px;">Lunas</button>
        @endif
        @endif

    </div>
</div>
<?php if ($returpenjualan) { ?>
    <div class="card">
        <div class="card-header">
            <h5>Retur Penjualan Faktur FJ-{{$faktur}} </h5>
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
                    @foreach($returpenjualan as $key => $value)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$value->nama}}</td>
                        <td>{{$value->jumlah}} Buah</td>
                        <td><?php echo "Rp ". number_format($value->harga, 0, ',', '.')?></td>
                        <td><?php echo "Rp ". number_format($value->harga * $value->jumlah, 0, ',', '.')?></td>
                        <?php
                        $retur += $value->jumlah * $value->harga;
                        ?>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <th colspan=4 style="text-align:center;">
                        Total Harga
                    </th>
                    <th>Rp. <?php echo $retur ?></th>
                </tfoot>
            </table>
        </div>
        <!-- /.card-body -->
        <div class="card-footer" style="display: inline-flex;position: relative;">
            <a href="{{ url('penjualan/')}}"><small class="btn btn-primary"><i class="fa fa-arrow-circle-left"></i> Kembali</small></a>
            @if (!$penjualan[0]->status)
            <button type="" data-toggle="modal" data-target="#proses" class="btn btn-primary" style="position: absolute;right: 20px;">Lunas</button>
            @endif

        </div>
    </div>
<?php } ?>

<div id="proses" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="icon-menu7"></i> &nbsp;Penjualan FJ-{{$faktur}}</h5>
            </div>
            <form role="form" method="post" action="{{url('penjualan/bayar') }}">
                {{csrf_field()}}
                <input type="hidden" name="faktur" class="form-control" placeholder="" value="<?php echo $faktur ?>">
                <div class="modal-body-logout" style="padding:20px;">
                    <div class="col-sm">
                        <!-- text input -->
                        <div class="form-group">
                            <label>Tanggal Pelunasan</label>
                            <input type="date" class="form-control" placeholder="" value="<?php echo $penjualan[0]->jatuhTempo; ?>" name="tanggal">
                        </div>
                        <div class="form-group">
                            <label>Total Pembayaran</label>
                            <input type="text" class="form-control" placeholder="" value="Rp. <?php echo $total-$retur?>" readonly>
                            <input type="hidden" class="form-control" placeholder="" value="<?php echo $total-$retur?>" name="totalbayar">
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
</div>
@endsection