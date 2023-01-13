@extends('master')
@section('title', 'Buku Besar')
@section('content')
@if ($message = Session::get('success'))
<div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h5><i class="icon fas fa-check"></i> Berhasil!</h5>
    {{$message}}
</div>
@endif
<form role="form" method="post" action="/buku_besar/search">
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
    @if($saldoAwal != null)
    <div style="text-align-last: center;">
        <h1>Buku Besar</h1>
        <h2><?php echo $bulan ?> <?php echo $tahun ?></h2>
    </div>

    @foreach($saldoAwal as $key => $value)
    <h4>{{$value->akunid}} - {{$value->nama}}</h4>
    <table id="tabel" class="table table-bordered table-hover ">
        <thead>
            <tr>
                <th rowspan="2">Tanggal</th>
                <th rowspan="2">Keterangan</th>
                <th rowspan="2">Debit</th>
                <th rowspan="2">Kredit</th>
                <th colspan="2">Saldo</th>

            </tr>
            <tr>
                <th>Debit</th>
                <th>Kredit</th>
            </tr>
        </thead>
        <?php $saldo = 0;?>
        <tbody>
            <tr>
                <td colspan="4">
                    Saldo Awal
                </td>
                <td colspan="2">
                    Bulan: {{$bulan}}<br>
                    Tahun: {{$tahun}}<br>
                    @if($value->saldoNormal == "Debit")
                    <?php echo "Rp " . number_format($value->saldo, 0, ',', '.') ?>
                    <?php $saldo = $value->saldo ?>
                    @else
                    <?php echo "Rp " . number_format(-$value->saldo, 0, ',', '.') ?>
                    <?php $saldo = $value->saldo ?>
                    @endif
                </td>
            </tr>
            @foreach($jurnalumum as $key2 => $value2)
            @if($value2->akun === $value->akunid)
            <tr>

                @if($value2->debit != null || $value2->kredit != null)
                <td>{{$value2->tanggal}}</td>
                <td>{{$value2->keterangan}}</td>
                @if($value2->debit != null)
                <td><?php echo "Rp ". number_format($value2->debit, 0, ',', '.')?></td>
                <?php $value->saldoNormal == "Debit" ? $saldo += $value2->debit : $saldo -= $value2->debit ?>
                @else
                <td>-</td>
                @endif
                @if($value2->kredit != null)
                <td><?php echo "Rp ". number_format($value2->kredit, 0, ',', '.')?></td>
                <?php $value->saldoNormal == "Kredit" ? $saldo += $value2->kredit : $saldo -= $value2->kredit ?>
                @else
                <td>-</td>
                @endif
                @if($value->saldoNormal == "Debit")
                <td><?php echo "Rp ". number_format($saldo, 0, ',', '.')?></td>
                @else
                <td></td>
                @endif
                @if($value->saldoNormal == "Kredit")
                <td><?php echo "Rp ". number_format($saldo, 0, ',', '.')?></td>
                @else
                <td></td>
                @endif
                @endif
            </tr>
            @endif
            @endforeach
        </tbody>
    </table>
    @endforeach
    @endif
    @endsection