<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Buku Besar</title>
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
        <h1>Buku Besar</h1>
        <h2><?php echo $bulan ?> <?php echo $tahun ?></h2>
    </div>

    @foreach($saldoAwal as $key => $value)
    <h4>{{$value->akunid}} - {{$value->nama}}</h4>
    <table id="tabel" class="table table-bordered table-hover ">
        <thead>
            <tr>
                <th rowspan="2">Tanggal</th>
                <th rowspan="2">Keterangan</th>
                <th rowspan="2">Debit</th>
                <th rowspan="2">Kredit</th>
                <th colspan="2">Saldo</th>

            </tr>
            <tr>
                <th>Debit</th>
                <th>Kredit</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="4">
                    Saldo Awal
                </td>
                <td colspan="2">
                    Bulan: {{$bulan}}<br>
                    Tahun: {{$tahun}}<br>
                    @if($value->saldoNormal == "Debit")
                    <?php echo "Rp " . number_format($value->saldo, 0, ',', '.') ?>
                    <?php $saldo = $value->saldo ?>
                    @else
                    <?php echo "Rp " . number_format(-$value->saldo, 0, ',', '.') ?>
                    <?php $saldo = $value->saldo ?>
                    @endif
                </td>
            </tr>
            @foreach($jurnalumum as $key2 => $value2)
            @if($value2->akun === $value->akunid)
            <tr>

                @if($value2->debit != null || $value2->kredit != null)
                <td>{{$value2->tanggal}}</td>
                <td>{{$value2->keterangan}}</td>
                @if($value2->debit != null)
                <td><?php echo "Rp " . number_format($value2->debit, 0, ',', '.') ?></td>
                <?php $value->saldoNormal == "Debit" ? $saldo += $value2->debit : $saldo -= $value2->debit ?>
                @else
                <td>-</td>
                @endif
                @if($value2->kredit != null)
                <td><?php echo "Rp " . number_format($value2->kredit, 0, ',', '.') ?></td>
                <?php $value->saldoNormal == "Kredit" ? $saldo += $value2->kredit : $saldo -= $value2->kredit ?>
                @else
                <td>-</td>
                @endif
                @if($value->saldoNormal == "Debit")
                <td><?php echo "Rp " . number_format($saldo, 0, ',', '.') ?></td>
                @else
                <td></td>
                @endif
                @if($value->saldoNormal == "Kredit")
                <td><?php echo "Rp " . number_format($saldo, 0, ',', '.') ?></td>
                @else
                <td></td>
                @endif
                @endif
            </tr>
            @endif
            @endforeach
        </tbody>
    </table>
    @endforeach
    <script type="text/javascript">
        window.addEventListener("load", window.print());
    </script>
</body>

</html>