<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Jurnal Penerimaan Kas</title>
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
        <h1>Jurnal Penerimaan Kas</h1>
        <h2><?php echo $bulan ?> <?php echo $tahun ?></h2>
    </div>
    <table id="tabel" class="table table-bordered table-hover ">
        <thead>
            <tr>
                <th rowspan="2">Tanggal</th>
                <th rowspan="2">No Faktur</th>
                <th colspan="3">Debit</th>
                <th colspan="3">Kredit</th>
            </tr>
            <tr>
                <th>Kas</th>
                <th>Diskon</th>
                <th>HPP</th>
                <th>Penjualan</th>
                <th>Piutang</th>
                <th>Persediaan</th>
            </tr>
        </thead>
        <?php $debit = 0;
        $kredit = 0; ?>
        <tbody>
            @foreach($jurnalKasMasuk as $key => $value)
            <?php $debit += $value->debitKas + $value->debitHargaPokokPenjualan;
            $kredit += $value->kreditPenjualan + $value->kreditPiutangUsaha + $value->kreditPersediaan; ?>
            <tr>
                <td>{{$value->tanggal}}</td>
                <td>{{$value->faktur}}</td>
                @if($value->debitKas != null)
                <td><?php echo "Rp " . number_format($value->debitKas, 0, ',', '.') ?></td>
                @else
                <td></td>
                @endif
                @if($value->debitDiskon != null)
                <td><?php echo "Rp " . number_format($value->debitDiskon, 0, ',', '.') ?></td>
                @else
                <td></td>
                @endif
                @if($value->debitHargaPokokPenjualan != null)
                <td><?php echo "Rp " . number_format($value->debitHargaPokokPenjualan, 0, ',', '.') ?></td>
                @else
                <td></td>
                @endif
                @if($value->kreditPenjualan != null)
                <td><?php echo "Rp " . number_format($value->kreditPenjualan, 0, ',', '.') ?></td>
                @else
                <td></td>
                @endif
                @if($value->kreditPiutangUsaha != null)
                <td><?php echo "Rp " . number_format($value->kreditPiutangUsaha, 0, ',', '.') ?></td>
                @else
                <td></td>
                @endif
                @if($value->kreditPersediaan != null)
                <td><?php echo "Rp " . number_format($value->kreditPersediaan, 0, ',', '.') ?></td>
                @else
                <td></td>
                @endif

            </tr>
            @endforeach
        </tbody>
        <tbottom>
            <th colspan=2>Total</th>
            <th colspan=3><?php echo "Rp " . number_format($debit, 0, ',', '.') ?></th>
            <th colspan=3><?php echo "Rp " . number_format($kredit, 0, ',', '.') ?></th>
        </tbottom>
    </table>
    <script type="text/javascript">
        window.addEventListener("load", window.print());
    </script>
</body>
</html>