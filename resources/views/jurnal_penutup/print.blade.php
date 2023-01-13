<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Jurnal Penutup</title>
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
    <script type="text/javascript">
        window.addEventListener("load", window.print());
    </script>
</body>

</html>