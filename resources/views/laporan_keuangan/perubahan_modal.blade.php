@extends('master')
@section('title', 'Laporan Perubahan Modal')
@section('content')
@if ($message = Session::get('success'))
<div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h5><i class="icon fas fa-check"></i> Berhasil!</h5>
    {{$message}}
</div>
@endif
<form role="form" method="post" action="/perubahan_modal/search">
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
    @if($modalSekarang != null || $labaSekarang != null)
    <?php $modalAkhir = 0;
    ?>
    <div style="text-align-last: center;">
        <h1>Laporan Perubahan Modal</h1>
        <h2><?php echo $bulan ?> <?php echo $tahun ?></h2>
    </div>
    <table class="table">
        <tbody style="text-align-last: center;">
            <tr>
                <td style=" border-top:0px;">Modal Awal</td>
                <td style="border-top:0px;"><?php echo "Rp " . number_format($modalSekarang, 0, ',', '.') ?></td>
            </tr>
            <tr>
                <td style=" border-top:0px;">Penanaman Modal</td>
                <td style="border-top:0px;"><?php echo "Rp " . number_format($penanamanModalSekarang, 0, ',', '.') ?></td>
            </tr>
            <tr>
                <td style="border-top:0px;">Laba Usaha</td>
                <td style="border-top:0px;"><?php echo "Rp " . number_format($labaSekarang, 0, ',', '.') ?></td>
            </tr>
            <tr>
                <th style="border-top:0px;">Modal Akhir</th>
                <th style="border-top:0px;"><?php echo "Rp " . number_format($modalSekarang + $labaSekarang + $penanamanModalSekarang, 0, ',', '.') ?></th>
            </tr>
        </tbody>
    </table>
    @endif
    @endsection