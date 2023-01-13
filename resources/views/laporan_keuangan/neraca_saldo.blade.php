@extends('master')
@section('title', 'Laporan Neraca')
@section('content')
@if ($message = Session::get('success'))
<div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h5><i class="icon fas fa-check"></i> Berhasil!</h5>
    {{$message}}
</div>
@endif
<form role="form" method="post" action="/neraca_saldo/search">
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
    @if($neraca_saldo != null)
    <div style="text-align-last: center;">
        <h1>Laporan Neraca Saldo</h1>
        <h2><?php echo $bulan ?> <?php echo $tahun ?></h2>
    </div>
    <table id="tabel" class="table table-bordered table-hover ">
        <thead>
            <tr>
                <th>No Akun</th>
                <th>Akun</th>
                <th>Debit</th>
                <th>Kredit</th>
            </tr>
        </thead>
        <?php $debit = 0;
        $kredit = 0; ?>
        <tbody>
            @foreach($neraca_saldo as $key => $value)
            <tr>
                <td>{{$value->akunid}}</td>
                <td>{{$value->nama}}</td>
                @if($value->saldoNormal == "Debit")
                <td><?php echo "Rp ". number_format($value->saldo, 0, ',', '.')?></td>
                <?php $debit += $value->saldo ?>
                @else
                <td></td>
                @endif
                @if($value->saldoNormal == "Kredit")
                <td><?php echo "Rp ". number_format(abs($value->saldo), 0, ',', '.')?></td>
                <?php $kredit += abs($value->saldo) ?>
                @else
                <td></td>
                @endif
            </tr>
            @endforeach
        </tbody>
        <tbottom>
            <tr>
                <th colspan="2"> Total</th>
                <th><?php echo "Rp ". number_format($debit, 0, ',', '.')?></th>
                <th><?php echo "Rp ". number_format($kredit, 0, ',', '.')?></th>
            </tr>
        </tbottom>
    </table>
    @endif
    @endsection