@extends('master')
@section('title', 'Laporan Laba Rugi')
@section('content')
@if ($message = Session::get('success'))
<div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h5><i class="icon fas fa-check"></i> Berhasil!</h5>
    {{$message}}
</div>
@endif
<form role="form" method="post" action="/laba_rugi/search">
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
</form>
@if($pendapatan != null || $beban != null)
<?php $debit = 0;
$kredit = 0;
$total = 0;
?>
<div style="text-align-last: center;">
    <h1>Laporan Laba Rugi</h1>
    <h2><?php echo $bulan ?> <?php echo $tahun ?></h2>
</div>
<table class="table">
    <tbody>
        <tr>
            <th colspan="3" style="border-top:0px;">Penjualan</th>
        </tr>
        @foreach($pendapatan as $key => $value)
        <tr>
            <td style="border-top:0px;">{{$value->akun}}</td>
            @if($value->akun == "Retur Penjualan")
            <td style="border-top:0px;">(<?php echo "Rp ". number_format($value->pendapatanKredit, 0, ',', '.')?>)</td>
            <?php $debit -= $value->pendapatanKredit?>
            @else
            <td style="border-top:0px;"><?php echo "Rp ". number_format($value->pendapatanDebit, 0, ',', '.')?></td>
            @endif
            <?php $debit += $value->pendapatanDebit ?>
        </tr>
        @endforeach
        <tr>
            <td style="border-top:0px;">Harga Pokok Penjualan</td>
            @foreach($hpp as $key => $value)
            <td style="border-top:0px;">(<?php echo "Rp ". number_format($value->hpp, 0, ',', '.')?>)</td>
            <?php $debit -= $value->hpp; ?>
            @endforeach
        </tr>
        <tr>
            <th style="border-top:0px;">&nbsp&nbsp&nbsp&nbsp&nbsp&nbspTotal Penjualan</th>
            <td style="border-top:0px;"></td>
            <th style="border-top:0px;"><?php echo "Rp ". number_format($debit, 0, ',', '.')?></th>
        </tr>
        <tr>
            <th colspan="3" style="border-top:0px;">Beban</th>
        </tr>
        @foreach($beban as $key => $value)
        <tr>
            <td style="border-top:0px;">{{$value->akun}}</td>
            <td style="border-top:0px;"><?php echo "Rp ". number_format($value->bebanKredit, 0, ',', '.')?></td>
            <?php $kredit += $value->bebanKredit ?>
        </tr>
        @endforeach
        @foreach($bebanpenyesuaian as $key => $value)
        <tr>
            <td style="border-top:0px;">{{$value->akun}}</td>
            <td style="border-top:0px;"><?php echo "Rp ". number_format($value->bebanKredit, 0, ',', '.')?></td>
            <?php $kredit += $value->bebanKredit ?>
        </tr>
        @endforeach
        <tr>
            <th style="border-top:0px;">&nbsp&nbsp&nbsp&nbsp&nbsp&nbspTotal Beban</th>
            <td style="border-top:0px;"></td>
            <th style="border-top:0px;">(<?php echo "Rp ". number_format($kredit, 0, ',', '.')?>)</th>
        </tr>
        <?php $total = $debit - $kredit; ?>
        <tr>
            <th style="border-top:0px;">Laba Usaha</th>
            <td style="border-top:0px;"></td>
            @if($total < 0) <th style="border-top:1px solid black;">(<?php echo "Rp ". number_format(-$total, 0, ',', '.')?>)</th>
                @else
                <th style="border-top:1px solid black;"><?php echo "Rp ". number_format($total, 0, ',', '.')?></th>
                @endif
        </tr>
    </tbody>
</table>
@endif
@endsection