<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Jurnal Penyesuaian</title>
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
        <h1>Jurnal Penyesuaian</h1>
        <h2><?php echo $bulan ?> <?php echo $tahun ?></h2>
    </div>
    <table id="tabel" class="table table-bordered table-hover ">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Beban</th>
                <th>Keterangan</th>
                <th>Debit</th>
                <th>Kredit</th>
            </tr>
        </thead>
        <?php $debit = 0; $kredit = 0;?>
        <tbody>
            @foreach($jurnalPenyesuaian as $key => $value)
            <tr>
                <?php $debit += $value->debit; $kredit += $value->kredit;?>
                <td>{{$value->tanggal}}</td>
                <td>BB-{{$value->bebanId}}</td>
                @if($value->debit != null)
                <td>{{$value->keterangan}}</td>
                @else
                <td>&nbsp&nbsp&nbsp&nbsp {{$value->keterangan}}</td>
                @endif
                @if($value->debit != null)
                <td><?php echo "Rp ". number_format($value->debit, 0, ',', '.')?></td>
                @else
                <td></td>
                @endif
                @if($value->kredit != null)
                <td><?php echo "Rp ". number_format($value->kredit, 0, ',', '.')?></td>
                @else
                <td></td>
                @endif
            </tr>
            @endforeach
        </tbody>
        <tbottom>
            <th colspan=3>Total</th>
            <th><?php echo "Rp ". number_format($debit, 0, ',', '.')?></th>
            <th><?php echo "Rp ". number_format($kredit, 0, ',', '.')?></th>
        </tbottom>
    </table>
    <script type="text/javascript">
        window.addEventListener("load", window.print());
    </script>
</body>

</html>