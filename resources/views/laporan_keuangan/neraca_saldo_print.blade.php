<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Neraca Saldo</title>
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
        <h1>Laporan Neraca Saldo</h1>
        <h2><?php echo $bulan ?> <?php echo $tahun ?></h2>
    </div>
    <table id="tabel" class="table table-bordered table-hover ">
        <thead>
            <tr>
                <th>No Akun</th>
                <th>Akun</th>
                <th>Debit</th>
                <th>Kredit</th>
            </tr>
        </thead>
        <?php $debit = 0;
        $kredit = 0; ?>
        <tbody>
            @foreach($neraca_saldo as $key => $value)
            <tr>
                <td>{{$value->akunid}}</td>
                <td>{{$value->nama}}</td>
                @if($value->saldoNormal == "Debit")
                <td><?php echo "Rp ". number_format($value->saldo, 0, ',', '.')?></td>
                <?php $debit += $value->saldo ?>
                @else
                <td></td>
                @endif
                @if($value->saldoNormal == "Kredit")
                <td><?php echo "Rp ". number_format(abs($value->saldo), 0, ',', '.')?></td>
                <?php $kredit += abs($value->saldo) ?>
                @else
                <td></td>
                @endif
            </tr>
            @endforeach
        </tbody>
        <tbottom>
            <tr>
                <th colspan="2"> Total</th>
                <th><?php echo "Rp ". number_format($debit, 0, ',', '.')?></th>
                <th><?php echo "Rp ". number_format($kredit, 0, ',', '.')?></th>
            </tr>
        </tbottom>
    </table>
    <script type="text/javascript">
        window.addEventListener("load", window.print());
    </script>
</body>

</html>