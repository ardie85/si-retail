@extends('master')
@section('title', 'Jurnal Penjualan')
@section('content')
@if ($message = Session::get('success'))
<div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h5><i class="icon fas fa-check"></i> Berhasil!</h5>
    {{$message}}
</div>
@endif
<form role="form" method="post" action="/jurnal_penjualan/search">
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
    @if($jurnalPenjualan != null)
    <div style="text-align-last: center;">
        <h1>Jurnal Penjualan</h1>
        <h2><?php echo $bulan ?> <?php echo $tahun ?></h2>
    </div>
    <?php $debit = 0; $kredit = 0;?>
    <table id="tabel" class="table table-bordered table-hover ">
        <thead>
            <tr>
                <th rowspan="2">Tanggal</th>
                <th rowspan="2">No Faktur</th>
                <th rowspan="2">Keterangan</th>
                <th colspan="6">Debit</th>
                <th colspan="5">Kredit</th>
            </tr>
            <tr>
                <th>Kas</th>
                <th>Piutang</th>
                <th>Diskon</th>
                <th>HPP</th>
                <th>Retur Penjualan</th>
                <th>Persediaan</th>
                <th>Penjualan</th>
                <th>Persediaan</th>
                <th>Kas</th>
                <th>HPP</th>
                <th>Piutang</th>
            </tr>
        </thead>
        <tbody>
            @foreach($jurnalPenjualan as $key => $value)
            <tr>
                <td>{{$value->jurnalPenjualanTgl}}</td>
                <td>FJ-{{$value->faktur}}</td>
                <td>{{$value->keterangan}}</td>
                <?php $debit += $value->debitKas + $value->debitPiutang + $value->debitHPP + $value->kreditDiskon+ $value->debitReturPenjualan + $value->debitPersediaan; $kredit += $value->kreditPenjualan + $value->kreditPersediaan + $value->kreditKas + $value->kreditHPP + $value->kreditPiutang;?>
                @if($value->debitKas != null)
                <td><?php echo "Rp ". number_format($value->debitKas, 0, ',', '.')?></td>
                @else
                <td></td>
                @endif
                @if($value->debitPiutang != null)
                <td><?php echo "Rp ". number_format($value->debitPiutang, 0, ',', '.')?></td>
                @else
                <td></td>
                @endif
                @if($value->kreditDiskon != null)
                <td><?php echo "Rp ". number_format($value->kreditDiskon, 0, ',', '.')?></td>
                @else
                <td></td>
                @endif
                @if($value->debitHPP != null)
                <td><?php echo "Rp ". number_format($value->debitHPP, 0, ',', '.')?></td>
                @else
                <td></td>
                @endif
                @if($value->debitReturPenjualan != null)
                <td><?php echo "Rp ". number_format($value->debitReturPenjualan, 0, ',', '.')?></td>
                @else
                <td></td>
                @endif
                @if($value->debitPersediaan != null)
                <td><?php echo "Rp ". number_format($value->debitPersediaan, 0, ',', '.')?></td>
                @else
                <td></td>
                @endif
                @if($value->kreditPenjualan != null)
                <td><?php echo "Rp ". number_format($value->kreditPenjualan, 0, ',', '.')?></td>
                @else
                <td></td>
                @endif
                @if($value->kreditPersediaan != null)
                <td><?php echo "Rp ". number_format($value->kreditPersediaan, 0, ',', '.')?></td>
                @else
                <td></td>
                @endif
                @if($value->kreditKas != null)
                <td><?php echo "Rp ". number_format($value->kreditKas, 0, ',', '.')?></td>
                @else
                <td></td>
                @endif
                @if($value->kreditHPP != null)
                <td><?php echo "Rp ". number_format($value->kreditHPP, 0, ',', '.')?></td>
                @else
                <td></td>
                @endif
                @if($value->kreditPiutang != null)
                <td><?php echo "Rp ". number_format($value->kreditPiutang, 0, ',', '.')?></td>
                @else
                <td></td>
                @endif

            </tr>
            @endforeach
        </tbody>
        <tbottom>
            <th colspan=3>Total</th>
            <th colspan=6><?php echo "Rp ". number_format($debit, 0, ',', '.')?></th>
            <th colspan=5><?php echo "Rp ". number_format($kredit, 0, ',', '.')?></th>
        </tbottom>
    </table>
    @endif
    @endsection