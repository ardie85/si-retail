@extends('master')
@section('title', 'Jurnal Pengeluaran Kas')
@section('content')
@if ($message = Session::get('success'))
<div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h5><i class="icon fas fa-check"></i> Berhasil!</h5>
    {{$message}}
</div>
@endif
<form role="form" method="post" action="/jurnal_kas_keluar/search">
    {{csrf_field()}}
    <div class="form-group row ">
        <label for="inputName" class="col-sm-2 col-form-label">Bulan</label>
        <select name="bulan" class="select-size-lg form-control" required>
            <option value="">Pilih : </option>
            <option value="01">Januari</option>
            <option value="02">Februari</option>
            <option value="03">Maret</option>
            <option value="04">April</option>
            <option value="05">Mei</option>
            <option value="06">Juni</option>
            <option value="07">Juli</option>
            <option value="08">Agustus</option>
            <option value="09">September</option>
            <option value="10">Oktober</option>
            <option value="11">November</option>
            <option value="12">Desember</option>
            <option value="13">Keseluruhan</option>
        </select>
    </div>
    <div class="form-group row ">
        <label for="inputName" class="col-sm-2 col-form-label">Tahun</label>

        <select name="tahun" class="select-size-lg form-control" required>
            <option value="">Pilih : </option>
            @foreach($periode as $key => $value)
            <option value='<?php echo $value->tahun ?>'>{{$value->tahun}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <button type="submit" name="action" class="btn btn-primary" value="Cari">Cari</button>
        <button type="submit" name="action" class="btn btn-default" value="Print"><i class="fas fa-print"></i>Print</button>
    </div>
    @if($jurnalKasKeluar != null)
    <div style="text-align-last: center;">
        <h1>Jurnal Pengeluaran Kas</h1>
        <h2><?php echo $bulan ?> <?php echo $tahun ?></h2>
    </div>
    <table id="tabel" class="table table-bordered table-hover ">
        <thead>
            <tr>
                <th rowspan="2">Tanggal</th>
                <th rowspan="2">No Faktur</th>
                <th colspan="4">Debit</th>
                <th colspan="2">Kredit</th>
            </tr>
            <tr>
                <th>Persediaan</th>
                <th>Hutang Usaha</th>
                <th>Beban</th>
                <th>Retur Penjualan</th>
                <th>Harga Pokok Penjualan</th>
                <th>Kas</th>

            </tr>
        </thead>
        <?php $debit = 0; $kredit = 0;?>
        <tbody>
            @foreach($jurnalKasKeluar as $key => $value)
            <?php $debit += $value->debitPersediaan +$value->debitHutangUsaha+$value->debitBeban+$value->debitReturPenjualan;
                $kredit += $value->kreditHargaPokokPenjualan + $value->kreditKas;
            ?>
            <tr>
                <td>{{$value->tanggal}}</td>
                <td>{{$value->faktur}}</td>
                @if($value->debitPersediaan != null)
                <td><?php echo "Rp ". number_format($value->debitPersediaan, 0, ',', '.')?></td>
                @else
                <td></td>
                @endif
                @if($value->debitHutangUsaha != null)
                <td><?php echo "Rp ". number_format($value->debitHutangUsaha, 0, ',', '.')?></td>
                @else
                <td></td>
                @endif
                @if($value->debitBeban != null)
                <td><?php echo "Rp ". number_format($value->debitBeban, 0, ',', '.')?></td>
                @else
                <td></td>
                @endif
                @if($value->debitReturPenjualan != null)
                <td><?php echo "Rp ". number_format($value->debitReturPenjualan, 0, ',', '.')?></td>
                @else
                <td></td>
                @endif
                @if($value->kreditHargaPokokPenjualan != null)
                <td><?php echo "Rp ". number_format($value->kreditHargaPokokPenjualan, 0, ',', '.')?></td>
                @else
                <td></td>
                @endif
                @if($value->kreditKas != null)
                <td><?php echo "Rp ". number_format($value->kreditKas, 0, ',', '.')?></td>
                @else
                <td></td>
                @endif

            </tr>
            @endforeach
        </tbody>
        <tbottom>
            <th colspan=2>Total</th>
            <th colspan=4><?php echo "Rp ". number_format($debit, 0, ',', '.')?></th>
            <th colspan=2><?php echo "Rp ". number_format($kredit, 0, ',', '.')?></th>
        </tbottom>
    </table>
    @endif
    @endsection