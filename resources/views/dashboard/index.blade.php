@extends('masterform')
@section('title', 'Dashboard')
@section('content')
<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
          <div class="inner">
            <h3><?php echo "Rp " . number_format($nilaiPersediaan, 0, ',', '.') ?></h3>

            <p>Barang</p>
          </div>
          <div class="icon">
            <i class="ion ion-bag"></i>
          </div>
          <a href="/barang" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
          <div class="inner">
            <h3><?php echo "Rp " . number_format($nilaiAset - $penyusutanAsetAktif, 0, ',', '.') ?></h3>

            <p>Aset</p>
          </div>
          <div class="icon">
            <i class="ion ion-stats-bars"></i>
          </div>
          <a href="/aset" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
          <div class="inner">
            <h3><?php echo "Rp " . number_format($penjualan, 0, ',', '.') ?></h3>

            <p>Penjualan</p>
          </div>
          <div class="icon">
            <i class="ion ion-person-add"></i>
          </div>
          <a href="/penjualan" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
          <div class="inner">
            <h3><?php echo "Rp " . number_format($pembelian, 0, ',', '.') ?></h3>

            <p>Pembelian</p>
          </div>
          <div class="icon">
            <i class="ion ion-pie-graph"></i>
          </div>
          <a href="/pembelian" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
    </div>
    <!-- /.row -->
    <!-- Main row -->
    <div class="row">
      <!-- Left col -->
      <section class="col-lg-7 connectedSortable ui-sortable">
        <!-- Custom tabs (Charts with tabs)-->
        <div class="card">
          <div class="card-header ui-sortable-handle" style="cursor: move;">
            <h3 class="card-title">
              <i class="fas fa-chart-pie mr-1"></i>
              Pendapatan
            </h3>
            <div class="card-tools">
              <ul class="nav nav-pills ml-auto">
                <li class="nav-item">
                  <a class="nav-link active" href="#revenue-chart" data-toggle="tab">Line</a>
                </li>
              </ul>
            </div>
          </div><!-- /.card-header -->
          <div class="card-body">
            <div class="tab-content p-0">
              <!-- Morris chart - Sales -->
              <div id="grafik"></div>
            </div>
          </div><!-- /.card-body -->
        </div>
        <!-- /.card -->
      </section>
      <section class="col-lg-5 connectedSortable ui-sortable">
      <div class="card card-primary card-outline card-tabs">
        <div class="card-header p-0 pt-1 border-bottom-0">
            <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-three-tunai-tab" data-toggle="pill" href="#custom-tabs-three-tunai" role="tab" aria-controls="custom-tabs-three-tunai" aria-selected="true">Penjualan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-three-kredit-tab" data-toggle="pill" href="#custom-tabs-three-kredit" role="tab" aria-controls="custom-tabs-three-kredit" aria-selected="false">Pembelian</a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="custom-tabs-three-tabContent">
                <div class="tab-pane fade show active" id="custom-tabs-three-tunai" role="tabpanel" aria-labelledby="custom-tabs-three-tunai-tab">
                    <table id="" class="table table-bordered table-hover ">
                        <thead>
                            <tr>
                                <th>No Faktur.</th>
                                <th>Jatuh Tempo</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                          @foreach($penjualanBelumLunas as $key => $value)
                          <tr>
                            <td>FJ-{{$value->faktur}}</td>
                            <td>{{$value->jatuhTempo}}</td>
                            <td><a href="{{url('penjualan/detail/'.$value->faktur)}}"><i class="nav-icon fa fa-search"></i></a></td>
                          </tr>
                          @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade" id="custom-tabs-three-kredit" role="tabpanel" aria-labelledby="custom-tabs-three-kredit-tab">
                    <table id="" class="table table-bordered table-hover ">
                        <thead>
                            <tr>
                                <th>No Faktur.</th>
                                <th>Jatuh Tempo</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($pembelianBelumLunas as $key => $value)
                          <tr>
                            <td>FB-{{$value->faktur}}</td>
                            <td>{{$value->jatuhTempo}}</td>
                            <td><a href="{{url('pembelian/detail/'.$value->faktur)}}"><i class="nav-icon fa fa-search"></i></a></td>
                          </tr>
                          @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
        <!-- /.card -->
    </div>
      </section>
      <!-- /.Left col -->
    </div>
    <!-- /.row (main row) -->
  </div><!-- /.container-fluid -->
  <script src="https://code.highcharts.com/highcharts.js"></script>
  <script type="text/javascript">
    var labarugi = <?php echo json_encode($labarugi) ?>;
    var bulan = <?php echo json_encode($bulan) ?>;
    Highcharts.chart('grafik', {
      title: {
        text: 'Grafik Pendapatan Bulanan'
      },
      xAxis: {
        categories: bulan
      },
      yAxis: {
        title: {
          text: 'Nominal Pendapatan Bulanan'
        }
      },
      plotOptions: {
        series: {
          allowPointSelect: true
        }
      },
      series: [{
        name: "Nominal Pendapatan",
        data: labarugi
      }]
    })
  </script>
</section>
<!-- /.content -->
@endsection