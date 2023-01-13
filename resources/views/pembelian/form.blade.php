@extends('masterform')
@section('title', 'Pembelian')
@section('judul', 'Form Pembelian')
@section('content')
<!-- SELECT2 EXAMPLE -->
<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <!-- left column -->
      <div class="col-md-6" style="max-width: 40%;">
        <!-- general form elements -->
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Form Pembelian Barang</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form role="form" method="post" action="{{($action1!='pembelian.add_barang') ? url($action1): route($action1) }}">
            {{csrf_field()}}
            <!-- /.card-header -->
            <div class="card-body">
              <div class="row">
                <div class="col-md">
                  <div class="form-group">
                    <label>Nama Barang</label>
                    <?php
                    // Koneksi
                    $server = "localhost";
                    $username = "root";
                    $password = "";
                    $database = "silk";
                    $con = mysqli_connect($server, $username, $password, $database);

                    $result = mysqli_query($con, "select * from barang");
                    $jsArray = "var prdName = new Array();\n";

                    echo '<select class="form-control select2bs4" name="id_barang" style="width: 100%;" onchange="changeValue(this.value)">';
                    echo '<option>Pilih Data Barang</option>';
                    while ($row = mysqli_fetch_array($result)) {
                      echo '<option value="' . $row['barangId'] . '">' . $row['nama'] . '</option>';
                      $jsArray .= "prdName['" . $row['barangId'] . "'] = {stok:'" . addslashes($row['stok']) . "',hargaBeli:'" . addslashes($row['hargaBeli']) . "'};\n";
                    }

                    echo '</select>' ?>
                  </div>
                </div>
              </div>
              <!-- /.row -->
              <div class="row">
                <div class="col-sm-6">
                  <!-- text input -->
                  <div class="form-group">
                    <label>Stok</label>
                    <input type="text" class="form-control" placeholder="" disabled id="stok" name="stok">
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Harga</label>
                    <input type="text" name="hargaBeli" class="form-control" placeholder="" id="hargaBeli" readonly="true">
                  </div>
                </div>
              </div>
              <script type="text/javascript">
                <?php echo $jsArray; ?>

                function changeValue(id) {
                  document.getElementById('stok').value = prdName[id].stok;
                  document.getElementById('hargaBeli').value = prdName[id].hargaBeli;
                };

                function getStock() {
                  return document.getElementById('stok').value; 
                }
              </script>
              <div class="row">
                <div class="col-sm-6">
                  <!-- text input -->
                  <div class="form-group">
                    <label>Jumlah</label>
                    <input type="number" id="jumlah"name="jumlah" class="form-control" placeholder="" min=1 required>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Harga Sekarang</label>
                    <input type="number" name="hargaBaru" class="form-control" placeholder="">
                  </div>
                </div>
              </div>
            </div>
            <div class="card-footer">
              <button type="submit" class="btn btn-primary">Tambah</button>
            </div>
          </form>
        </div>
        <!-- /.card -->
      </div>
      <!--/.col (left) -->
      <!-- right column -->
      <div class="col-md" style="width: 60%;">
        <!-- general form elements disabled -->
        <div class="card card-warning">
          <div class="card-header">
            <h3 class="card-title">Faktur Pembelian - <?php echo $faktur + 1 ?></h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="tabel_beli" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>No.</th>
                  <th>Nama Barang</th>
                  <th>Harga</th>
                  <th>Jumlah</th>
                  <th>Total Harga</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php $total = 0; ?>
                @foreach($pembelian as $key => $value)
                <tr>
                  <td>{{$key+1}}</td>
                  @foreach($barang as $key2 => $value2)
                  @if($value2->barangId == $value->barangId)
                  <td>{{$value2->nama}}</td>
                  @endif
                  @endforeach
                  <td><?php echo "Rp " . number_format($value->harga, 0, ',', '.') ?></td>
                  <td>{{$value->jumlah}}</td>
                  <td><?php echo "Rp " . number_format($value->harga*$value->jumlah, 0, ',', '.') ?></td>
                  <td>
                    <a href="{{url('pembelian/delete/'.$value->pembelianid)}}"><i class="nav-icon fa fa-trash"></i></a>
                  </td>
                  <?php $total += $value->harga * $value->jumlah; ?>
                </tr>
                @endforeach
              </tbody>
              <tfoot>
                <th colspan="4"> Total </th>
                <th colspan="2"><?php echo "Rp " . number_format($total, 0, ',', '.') ?></th>
              </tfoot>
            </table>
          </div>
          <div class="card-footer">
            <button type="" data-toggle="modal" data-target="#proses" class="btn btn-primary">Proses</button>
          </div>
        </div>
        <form method="post" action="{{($action!='pembelian.update') ? url($action): route($action) }}">
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
                      <label>Tanggal Pembelian</label>
                      <input type="date" class="form-control" placeholder="" value="<?php echo $tahun . '-01-01'; ?>" name="tanggal">
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
                      <label>Supplier</label>
                      <select name="supplierId" class="select-size-lg form-control" required>
                        <option value="">Pilih : </option>
                        @foreach($supplier as $key => $value)
                        <option value='<?php echo $value->supplierId ?>'>{{$value->nama}}</option>
                        @endforeach

                      </select>
                    </div>
                  </div>
                  <div class="col-sm">
                    <div class="row">
                      <div class="col-sm-6">
                        <!-- checkbox -->
                        <div class="form-group">
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="radio1" id="tunai" value="Tunai" onclick="text(0)" checked>
                            <label class="form-check-label">Tunai</label>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <!-- radio -->
                        <div class="form-group">
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="radio1" id="kredit" value="Kredit" onclick="text(1)">
                            <label class="form-check-label">Kredit</label>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm">
                    <div class="form-group" style="display:none;" id="mycode">
                      <label>Jatuh Tempo</label>
                      <input type="date" name="jatuhTempo" class="form-control" placeholder="" value="<?php echo $tahun . '-01-01' ?>">
                    </div>
                  </div>
                  <div class="col-sm">
                    <div class="form-group">
                      <label>Total Harga</label>
                      <input type="text"  class="form-control" placeholder="" value="<?php echo "Rp " . number_format($total, 0, ',', '.') ?>" readonly="true">
                      <input type="hidden" name="totalHarga" class="form-control" placeholder="" value="<?php echo $total; ?>" readonly="true">
                    </div>
                  </div>
                  <input type="hidden" name="faktur" class="form-control" placeholder="" value="<?php echo $faktur + 1; ?>">
                </div>

                <div class="modal-footer">
                  <button class="btn btn-danger" data-dismiss="modal"><i class="icon-cross"></i> Close</button>
                  <button class="btn btn-primary" type="submit"><i class="icon-switch2"></i> Bayar</button>
                </div>
              </div>
            </div>
          </div>
        </form>
        <!-- /.card -->
      </div>
      <!--/.col (right) -->

      <!-- /.card -->
    </div>
  </div>
  @endsection