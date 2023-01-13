<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Perubahan Modal</title>
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
                <td style="border-top:0px;"><?php echo "Rp ". number_format($modalSekarang, 0, ',', '.')?></td>
            </tr>
            <tr>
                <td style=" border-top:0px;">Penanaman Modal</td>
                <td style="border-top:0px;"><?php echo "Rp " . number_format($penanamanModalSekarang, 0, ',', '.') ?></td>
            </tr>
            <tr>
                <td style="border-top:0px;">Laba Usaha</td>
                <td style="border-top:0px;"><?php echo "Rp ". number_format($labaSekarang, 0, ',', '.')?></td>
            </tr>
            <tr>
                <th style="border-top:0px;">Modal Akhir</th>
                <th style="border-top:0px;"><?php echo "Rp ". number_format($modalSekarang + $labaSekarang + $penanamanModalSekarang, 0, ',', '.')?></th>
            </tr>
        </tbody>
    </table>
    <script type="text/javascript">
        window.addEventListener("load", window.print());
    </script>
</body>

</html>