@extends('master')
@section('title', 'Retur Pembelian')
@section('judul', 'Form Retur Pembelian')
@section('content')
<div class="card">
    <!-- /.card-header -->
    <div class="card-body">
        <table style="width:100%">
            <tr>
                <td style="width:33.3%">
                    <span style="display: inline-block; width: 140px;">Supplier :</span>
                    <select class="form-control" style="display: inline-block; width: 50%;" name="supplier" value="{{$supplier[0]->nama}}" disabled>
                        <option>{{$supplier[0]->nama}}</option>
                    </select>

                </td>
                <td style="width:33.3%">
                    <span style="display: inline-block; width: 140px;">User :</span>
                    <div class="input-group date" id="reservationdate" data-target-input="nearest" style="display: inline-block; width: 50%;">
                        <input type="text" class="form-control" name="pengguna" value="{{$pengguna[0]->nama}}" disabled />
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
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Total</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dataRetur as $key => $value)
            <tr>
                <td>{{$key+1}}</td>
                <td>{{$value->kode}}</td>
                <td>{{$value->nama}}</td>
                <td>{{$value->jumlah}}</td>
                <td>Rp. {{$value->harga}}</td>
                <td>Rp. <?php echo ($value->jumlah * $value->harga); ?></td>
                <?php $total +=  ($value->jumlah * $value->harga); ?>
                <td>
                    <a href="{{url('retur_pembelian/delete/'.$value->returPembelianId)}}"><i class="nav-icon fa fa-trash"></i></a>
                </td>
            </tr>
            @endforeach
        </tbody>
        <tbottom>
            <tr>
                <th colspan="5" style="text-align:center;">Total Harga</th>
                <th colspan="2">Rp. <?php echo $total ?></th>
            </tr>
        </tbottom>
    </table>
</div>
<!-- /.card-body -->
<div class="card-footer">
    <button type="" data-toggle="modal" data-target="#tambah" class="btn btn-primary">List Barang</button>
    <button type="" data-toggle="modal" data-target="#proses" class="btn btn-primary float-right">Proses</button>
</div>
<!-- Tambah Modal -->
<form method="post" action="{{($action1!='retur_pembelian.add_barang') ? url($action1): route($action1) }}">
    {{csrf_field()}}
    <div id="tambah" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="icon-menu7"></i> &nbsp;List Barang</h5>
                </div>

                <div class="modal-body-logout" style="padding:20px;">
                    <div class="col-sm">
                        <!-- text input -->
                        <div class="form-group">
                            <label>Barang</label>
                            <?php
                            // Koneksi
                            $server = "localhost";
                            $username = "root";
                            $password = "";
                            $database = "silk";
                            $con = mysqli_connect($server, $username, $password, $database);

                            $result = mysqli_query($con, "SELECT b.nama as b_nama, b.stok as b_stok, pb.jumlah, pb.harga, b.barangId as barangId FROM pembelian as pb, barang as b WHERE faktur = $faktur AND b.barangId = pb.barangId");
                            $jsArray = "var prdName = new Array();\n";

                            echo '<select class="form-control select2bs4" name="barangId" style="width: 100%;" onchange="changeValue(this.value)">';
                            echo '<option>Pilih Data Barang</option>';
                            while ($row = mysqli_fetch_array($result)) {
                                echo '<option value="' . $row['barangId'] . '">' . $row['b_nama'] . '</option>';
                                $jsArray .= "prdName['" . $row['barangId'] . "'] = {jumlah:" . addslashes($row['jumlah']) . ",harga:'" . addslashes($row['harga']) . "', stok:" . addslashes($row['b_stok']) . "};\n";
                            }
                            echo '</select>' ?>
                            <script type="text/javascript">
                                <?php echo $jsArray; ?>

                                function changeValue(id) {
                                    document.getElementById('jumlah').value = prdName[id].jumlah;
                                    document.getElementById('stok').value = prdName[id].stok;
                                    document.getElementById('harga').value = prdName[id].harga;
                                    console.log(prdName[id].stok < prdName[id].jumlah);
                                    if(prdName[id].stok < prdName[id].jumlah) document.getElementById('jumlah_retur').setAttribute("max", prdName[id].stok);
                                    else document.getElementById('jumlah_retur').setAttribute("max", prdName[id].jumlah);

                                };

                                function getJumlah() {
                                    return document.getElementById('jumlah').value;
                                }
                            </script>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-group">
                            <label>Jumlah Pembelian Sebelumnya</label>
                            <input type="number" name="jumlah" class="form-control" id="jumlah" placeholder="" disabled>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-group">
                            <label>Stok Sekarang</label>
                            <input type="number" name="stok" class="form-control" id="stok" placeholder="" disabled>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-group">
                            <label>Harga Pembelian</label>
                            <input type="text" name="harga" class="form-control" id="harga" placeholder="" readonly="true">
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-group">
                            <label>Jumlah Retur</label>
                            <input type="number" name="jumlah_retur" class="form-control" placeholder="" id="jumlah_retur" value="" min="1" required>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="faktur" value="{{$faktur}}">
                <input type="hidden" name="supplierId" value="{{$supplier[0]->supplierId}}">
                <input type="hidden" name="penggunaId" value="{{$pengguna[0]->penggunaId}}">
                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal"><i class="icon-cross"></i> Tutup</button>
                    <button class="btn btn-primary" type="submit"><i class="icon-switch2"></i> Tambah</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- Proses Modal -->
<form method="post" action="{{($action!='retur_pembelian.update') ? url($action): route($action) }}">
    {{csrf_field()}}
    <div id="proses" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="icon-menu7"></i> &nbsp;Form Data</h5>
                </div>

                <div class="modal-body-logout" style="padding:20px;">
                    <div class="col-sm">
                        <!-- text input -->
                        <div class="form-group">
                            <label>Tanggal Retur</label>
                            <input type="date" class="form-control" placeholder="" name="tanggal" value="{{$tanggal[0]->tanggal}}" required>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-group">
                            <label>Keterangan</label>
                            <input type="text" name="keterangan" class="form-control" placeholder="" value="-">
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-group">
                            <label>Jenis Pembayaran</label>
                            <select class="select-size-lg form-control" disabled>
                                <option>{{$metodePembayaran[0]->metodePembayaran}}</option>
                            </select>
                            <input type="hidden" name="metodePembayaran" value="{{$metodePembayaran[0]->metodePembayaran}}">
                            <input type="hidden" name="totalHarga" value="{{$total}}">
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-group">
                            <label>Status Pelunasan</label>
                            <input type="text" class="form-control" placeholder="" value="<?php echo $pembelian[0]->status ? "Lunas" : "Belum Lunas" ?>" readonly>
                            <input type="hidden" name="status" class="form-control" placeholder="" value="{{$pembelian[0]->status}}" readonly>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="faktur" value="{{$faktur}}">
                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal"><i class="icon-cross"></i> Tutup</button>
                    <button class="btn btn-primary" type="submit"><i class="icon-switch2"></i> Retur</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection