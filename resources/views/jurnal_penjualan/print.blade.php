<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Jurnal Penjualan</title>
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
        <h1>Jurnal Penjualan</h1>
        <h2><?php echo $bulan ?> <?php echo $tahun ?></h2>
    </div>
    <?php $debit = 0;
    $kredit = 0; ?>
    <table id="tabel" class="table table-bordered table-hover ">
        <thead>
            <tr>
                <th rowspan="2">Tanggal</th>
                <th rowspan="2">No Faktur</th>
                <th rowspan="2">Keterangan</th>
                <th colspan="6">Debit</th>
                <th colspan="4">Kredit</th>
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
            </tr>
        </thead>
        <tbody>
            @foreach($jurnalPenjualan as $key => $value)
            <tr>
                <td>{{$value->jurnalPenjualanTgl}}</td>
                <td>FJ-{{$value->faktur}}</td>
                <td>{{$value->keterangan}}</td>
                <?php $debit += $value->debitKas + $value->debitPiutang + $value->debitHPP + $value->kreditDiskon + $value->debitReturPenjualan + $value->debitPersediaan;
                $kredit += $value->kreditPenjualan + $value->kreditPersediaan + $value->kreditKas + $value->kreditHPP; ?>
                @if($value->debitKas != null)
                <td><?php echo "Rp " . number_format($value->debitKas, 0, ',', '.') ?></td>
                @else
                <td></td>
                @endif
                @if($value->debitPiutang != null)
                <td><?php echo "Rp " . number_format($value->debitPiutang, 0, ',', '.') ?></td>
                @else
                <td></td>
                @endif
                @if($value->kreditDiskon != null)
                <td><?php echo "Rp " . number_format($value->kreditDiskon, 0, ',', '.') ?></td>
                @else
                <td></td>
                @endif
                @if($value->debitHPP != null)
                <td><?php echo "Rp " . number_format($value->debitHPP, 0, ',', '.') ?></td>
                @else
                <td></td>
                @endif
                @if($value->debitReturPenjualan != null)
                <td><?php echo "Rp " . number_format($value->debitReturPenjualan, 0, ',', '.') ?></td>
                @else
                <td></td>
                @endif
                @if($value->debitPersediaan != null)
                <td><?php echo "Rp " . number_format($value->debitPersediaan, 0, ',', '.') ?></td>
                @else
                <td></td>
                @endif
                @if($value->kreditPenjualan != null)
                <td><?php echo "Rp " . number_format($value->kreditPenjualan, 0, ',', '.') ?></td>
                @else
                <td></td>
                @endif
                @if($value->kreditPersediaan != null)
                <td><?php echo "Rp " . number_format($value->kreditPersediaan, 0, ',', '.') ?></td>
                @else
                <td></td>
                @endif
                @if($value->kreditKas != null)
                <td><?php echo "Rp " . number_format($value->kreditKas, 0, ',', '.') ?></td>
                @else
                <td></td>
                @endif
                @if($value->kreditHPP != null)
                <td><?php echo "Rp " . number_format($value->kreditHPP, 0, ',', '.') ?></td>
                @else
                <td></td>
                @endif

            </tr>
            @endforeach
        </tbody>
        <tbottom>
            <th colspan=3>Total</th>
            <th colspan=6><?php echo "Rp " . number_format($debit, 0, ',', '.') ?></th>
            <th colspan=4><?php echo "Rp " . number_format($kredit, 0, ',', '.') ?></th>
        </tbottom>
    </table>
    <script type="text/javascript">
        window.addEventListener("load", window.print());
    </script>
</body>

</html>