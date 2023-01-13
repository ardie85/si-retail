<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Laba Rugi</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 4 -->

    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">

    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body>
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
    <script type="text/javascript">
        window.addEventListener("load", window.print());
    </script>
</body>

</html>