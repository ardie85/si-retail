@extends('master')
@section('title', 'Jurnal Penutup')
@section('content')
@if ($message = Session::get('success'))
<div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h5><i class="icon fas fa-check"></i> Berhasil!</h5>
    {{$message}}
</div>
@endif
<form role="form" method="post" action="/jurnal_penutup/search">
    {{csrf_field()}}
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
    @if($neracaSaldo != null)
    <div style="text-align-last: center;">
        <h1>Jurnal Penutup</h1>
        <h2>Desember <?php echo 2019 ?></h2>
    </div>
    <?php
    $penjualanbersih = 0;
    foreach($neracaSaldo as $key => $value){
        if($value->akunid == 4102 || $value->akunid == 4104 || $value->akunid == 5101){
            $ikhLabaRugi2 += $value->saldo;
        }
    }
    
    ?>
    <table id="tabel" class="table table-bordered table-hover ">
        <thead>
            <tr>
                <th colspan=2>Tanggal</th>
                <th>Keterangan</th>
                <th>Debit</th>
                <th>Kredit</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td rowspan=3>Des</td>
                <td rowspan=3>31</td>
                <td>Penjualan</td>
                @foreach($neracaSaldo as $key =>$value)
                @if($value->akunid == 4101)
                <td><?php echo "Rp " . number_format($value->saldo, 0, ',', '.') ?></td>
                <?php $penjualanbersih += $value->saldo; ?>
                @endif
                @endforeach
                <td></td>
            </tr>
            <tr>
                <td>Pendapatan Usaha Lainnya</td>
                @foreach($neracaSaldo as $key =>$value)
                @if($value->akunid == 4103)
                <td><?php echo "Rp " . number_format($value->saldo, 0, ',', '.') ?></td>
                <?php $penjualanbersih += $value->saldo; ?>
                @endif
                @endforeach
                <td></td>
            </tr>
            <tr>
                <td>&nbsp&nbsp&nbsp Ikhtisar Laba/Rugi</td>
                <td>
                <td><?php echo "Rp " . number_format($penjualanbersih, 0, ',', '.') ?></td>
            </tr>
            <tr></tr>
            <!-- Beban dan Retur penjualan, HPP -->
            <tr>
                <td rowspan=<?php echo $rowcountbeban[0]->total + 4 ?>>Des</td>
                <td rowspan=<?php echo $rowcountbeban[0]->total + 4 ?>>31</td>
                <td>Ikhtisar Laba/Rugi</td>
                <td><?php echo "Rp " . number_format($ikhLabaRugi2, 0, ',', '.') ?></td>
                <td>
            </tr>
            @foreach($neracaSaldo as $key =>$value)
            @if($value->akunid == 5101 || $value->akunid == 4102 || $value->akunid == 4104)
            <tr>
                <td>&nbsp&nbsp&nbsp{{$value->nama}}</td>
                <td></td>
                <td><?php echo "Rp " . number_format($value->saldo, 0, ',', '.') ?></td>
            </tr>
            @endif
            @endforeach
            @foreach($beban as $key => $value)
            <tr>
                <td>&nbsp&nbsp&nbsp{{$value->nama}}</td>
                <td></td>
                <td><?php echo "Rp " . number_format($value->saldo, 0, ',', '.') ?></td>
            </tr>
            @endforeach
            <tr></tr>
            <!-- Modal  -->
            <tr>
                <td rowspan=2>Des</td>
                <td rowspan=2>31</td>
                <td>Ikhtisar Laba Rugi</td>
                <td><?php echo "Rp " . number_format(($penjualanbersih-$ikhLabaRugi2), 0, ',', '.') ?></td>
                <td></td>
            </tr>
            <tr>
                <td>&nbsp&nbsp&nbspModal</td>
                <td></td>
                <td><?php echo "Rp " . number_format(($penjualanbersih-$ikhLabaRugi2), 0, ',', '.') ?></td>
            </tr>
        </tbody>
    </table>
    @endif
    @endsection