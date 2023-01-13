@extends('masterform')
@section('title', "Detail Retur Pembelian")
@section('content')
<div class="card">
    <div class="card-header">
        <h5>Retur Pembelian Faktur FB-{{$faktur}} </h5>
    </div>
    <!-- /.card-header -->
    <?php $total = 0; ?>
    <div class="card-body">
        <table style="width:100%">
            <tr>
                <td style="width:33.3%">
                    <span style="display: inline-block; width: 140px;">Supplier :</span>
                    <select class="form-control" style="display: inline-block; width: 50%;" name="supplier" value="" disabled>
                        <option>{{$returpembelian[0]->s_nama}}</option>
                    </select>

                </td>
                <td style="width:33.3%">
                    <span style="display: inline-block; width: 140px;">User :</span>
                    <div class="input-group date" id="reservationdate" data-target-input="nearest" style="display: inline-block; width: 50%;">
                        <input type="text" class="form-control" name="pengguna" value="{{$returpembelian[0]->p_nama}}" disabled />
                    </div>

    </div>
    </td>
    <td style="width:33.3%">
        <span style="display: inline-block; width: 140px;">Faktur :</span>
        <input type="text" class="form-control" placeholder="#100000" style="display: inline-block; width: 50%;" name="" value="FB-{{$faktur}}" disabled>

    </td>
    </tr>
    </table>
    <?php $total = 0 ?>
    <table class="table table-bordered table-hover" style="margin-top:20px;">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Tanggal</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($returpembelian as $key => $value)
            <tr>
                <td>{{$key+1}}</td>
                <td>{{$value->kode}}</td>
                <td>{{$value->nama}}</td>
                <td>{{$value->tanggal}}</td>
                <td>{{$value->jumlah}}</td>
                <td><?php echo "Rp ". number_format($value->harga, 0, ',', '.')?></td>
                <td><?php echo "Rp ". number_format($value->harga * $value->jumlah, 0, ',', '.')?></td>
                <?php $total +=  ($value->jumlah * $value->harga); ?>
            </tr>
            @endforeach
        </tbody>
        <tbottom>
            <tr>
                <th colspan="6" style="text-align:center;">Total Harga</th>
                <th><?php echo "Rp ". number_format($total, 0, ',', '.')?></th>
            </tr>
        </tbottom>
    </table>
    <!-- /.card-body -->
</div>
<div class="card-footer" style="display: inline-flex;position: relative;">
    <a href="{{ url('retur_pembelian/')}}"><small class="btn btn-primary"><i class="fa fa-arrow-circle-left"></i> Kembali</small></a>
</div>
@endsection