@extends('master')
@section('title', 'Jurnal Penyesuaian')
@section('content')
@if ($message = Session::get('success'))
<div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h5><i class="icon fas fa-check"></i> Berhasil!</h5>
    {{$message}}
</div>
@endif
<form role="form" method="post" action="/jurnal_penyesuaian/search">
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
    @if($jurnalPenyesuaian != null)
    <div style="text-align-last: center;">
        <h1>Jurnal Penyesuaian</h1>
        <h2><?php echo $bulan ?> <?php echo $tahun ?></h2>
    </div>
    <table id="tabel" class="table table-bordered table-hover ">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Beban</th>
                <th>Keterangan</th>
                <th>Debit</th>
                <th>Kredit</th>
            </tr>
        </thead>
        <?php $debit = 0; $kredit = 0;?>
        <tbody>
            @foreach($jurnalPenyesuaian as $key => $value)
            <tr>
                <?php $debit += $value->debit; $kredit += $value->kredit;?>
                <td>{{$value->tanggal}}</td>
                <td>BB-{{$value->bebanId}}</td>
                @if($value->debit != null)
                <td>{{$value->keterangan}}</td>
                @else
                <td>&nbsp&nbsp&nbsp&nbsp {{$value->keterangan}}</td>
                @endif
                @if($value->debit != null)
                <td><?php echo "Rp ". number_format($value->debit, 0, ',', '.')?></td>
                @else
                <td></td>
                @endif
                @if($value->kredit != null)
                <td><?php echo "Rp ". number_format($value->kredit, 0, ',', '.')?></td>
                @else
                <td></td>
                @endif
            </tr>
            @endforeach
        </tbody>
        <tbottom>
            <th colspan=3>Total</th>
            <th><?php echo "Rp ". number_format($debit, 0, ',', '.')?></th>
            <th><?php echo "Rp ". number_format($kredit, 0, ',', '.')?></th>
        </tbottom>
    </table>
    @endif
    @endsection