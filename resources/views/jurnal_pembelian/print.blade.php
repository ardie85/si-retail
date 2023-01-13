<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Jurnal Pembelian</title>
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
        <h1>Jurnal Pembelian</h1>
        <h2><?php echo $bulan ?> <?php echo $tahun ?></h2>
    </div>
    <?php $debit = 0; $kredit = 0; ?>
    <table id="tabel" class="table table-bordered table-hover ">
        <thead>
            <tr>
                <th rowspan="2">Tanggal</th>
                <th rowspan="2">No Faktur</th>
                <th rowspan="2">keterangan</th>
                <th colspan="3">Debit</th>
                <th colspan="3">Kredit</th>
            </tr>
            <tr>
                <th>Persediaan</th>
                <th>Hutang Usaha</th>
                <th>Kas</th>
                <th>Hutang Usaha</th>
                <th>Kas</th>
                <th>Persediaan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($jurnalPembelian as $key => $value)
            <tr>
                <td>{{$value->jurnalPembelianTgl}}</td>
                <td>FB-{{$value->faktur}}</td>
                <td>{{$value->keterangan}}</td>
                @if($value->debitPersediaan != null)
                <td><?php echo "Rp ". number_format($value->debitPersediaan, 0, ',', '.')?></td>
                @else
                <td></td>
                @endif
                @if($value->debitHutang != null)
                <td><?php echo "Rp ". number_format($value->debitHutang, 0, ',', '.')?></td>
                @else
                <td></td>
                @endif
                @if($value->debitKas != null)
                <td><?php echo "Rp ". number_format($value->debitKas, 0, ',', '.')?></td>
                @else
                <td></td>
                @endif
                <?php $debit += $value->debitPersediaan+ $value->debitKas + $value->debitHutang; $kredit += $value->kreditHutang + $value->kreditKas + $value->kreditPersediaan?>

                @if($value->kreditHutang != null)
                <td><?php echo "Rp ". number_format($value->kreditHutang, 0, ',', '.')?></td>
                @else
                <td></td>
                @endif
                @if($value->kreditKas != null)
                <td><?php echo "Rp ". number_format($value->kreditKas, 0, ',', '.')?></td>
                @else
                <td></td>
                @endif
                @if($value->kreditPersediaan != null)
                <td><?php echo "Rp ". number_format($value->kreditPersediaan, 0, ',', '.')?></td>
                @else
                <td></td>
                @endif

            </tr>
            @endforeach
        </tbody>
        <tbottom>
            <th colspan=3>Total</th>
            <th colspan=3><?php echo "Rp ". number_format($debit, 0, ',', '.')?></th>
            <th colspan=3><?php echo "Rp ". number_format($kredit, 0, ',', '.')?></th>
        </tbottom>
    </table>
    <script type="text/javascript">
        window.addEventListener("load", window.print());
    </script>
</body>
</html>