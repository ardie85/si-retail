<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset ('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset ('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="{{asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}"><!-- Bootstrap4 Duallistbox -->
    <link rel="stylesheet" href="{{asset('plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
    <script>
        function text(x) {
            if (x === 0) document.getElementById("mycode").style.display = "none";
            else document.getElementById("mycode").style.display = "block";
            return;
        }

        function format_rupiah(number) {
            return number.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ".");
        }
    </script>
</head>

<body class="hold-transition sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>
            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Hi, &nbsp{{session('nama')}}</a>
                    <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow" style="left: 0px; right: inherit;">
                        <!-- <li><a href="#" class="dropdown-item">Tutup Periode</a></li> -->
                        @if (Session::get('jenis') === "admin")
                        <li><button type="" data-toggle="modal" data-target="#tutup" class="btn dropdown-item">Tutup Periode</button></li>
                        @endif
                        <li><a class="dropdown-item" href="{{url('logout/')}}" style="color:red">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user (optional) -->
                <div class="user-panel pb-3 mt-3 mb-3 d-flex">
                    <div class="image">
                        <img src="/dist/img/default-150x150.png" class="img-circle img-size-32 mr-2">
                    </div>
                    <div class="info">
                        <a href="" class="d-block">SILK</a>
                    </div>
                </div>

                <!-- Sidebar Menu -->

                <nav class="mt-2">

                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        @if (Session::get('jenis') === "admin")
                        <li class="nav-item">
                            <a href="{{url('dashboard/')}}" class="nav-link {{ Request::is('dashboard') || Request::is('dashboard/*') ? 'active' : '' }}">
                                <i class="nav-icon far fa-money-bill-alt"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link {{ Request::is('akun') || Request::is('akun/*') ? 'active' : '' }} {{ Request::is('akunSaldo') || Request::is('akunSaldo/*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-list-alt"></i>
                                <p>
                                    Akun
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{url('akun/')}}" class="nav-link {{ Request::is('akun') || Request::is('akun/*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Daftar Akun</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{url('akunSaldo/')}}" class="nav-link {{ Request::is('akunSaldo') || Request::is('akunSaldo/*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Akun Saldo Awal</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endif
                        @if (Session::get('jenis') === "admin")
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link {{ Request::is('barang') || Request::is('barang/*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-boxes"></i>
                                <p>
                                    Barang
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">

                                <li class="nav-item">
                                    <a href="{{url('barang/')}}" class="nav-link {{ Request::is('barang') || Request::is('barang/*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Data Barang</p>
                                    </a>
                                </li>

                            </ul>
                        </li>
                        @endif
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link {{ Request::is('retur_penjualan') || Request::is('retur_penjualan/*') ? 'active' : '' }} {{ Request::is('retur_pembelian') || Request::is('retur_pembelian/*') ? 'active' : '' }} {{ Request::is('pembelian') || Request::is('pembelian/*') ? 'active' : '' }} {{ Request::is('penjualan') || Request::is('penjualan/*') ? 'active' : '' }}">
                                <i class="nav-icon far fa-money-bill-alt"></i>
                                <p>
                                    Transaksi
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @if (Session::get('jenis') === "admin")
                                <li class="nav-item">
                                    <a href="{{url('pembelian/')}}" class="nav-link {{ Request::is('pembelian') || Request::is('pembelian/*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Transaksi Pembelian</p>
                                    </a>
                                </li>
                                @endif
                                <li class="nav-item">
                                    <a href="{{url('penjualan/')}}" class="nav-link {{ Request::is('penjualan') || Request::is('penjualan/*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Transaksi Penjualan</p>
                                    </a>
                                </li>
                                @if (Session::get('jenis') === "admin")
                                <li class="nav-item">
                                    <a href="{{url('retur_pembelian/')}}" class="nav-link {{ Request::is('retur_pembelian') || Request::is('retur_pembelian/*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Retur Pembelian</p>
                                    </a>
                                </li>
                                @endif
                                <li class="nav-item">
                                    <a href="{{url('retur_penjualan/')}}" class="nav-link {{ Request::is('retur_penjualan') || Request::is('retur_penjualan/*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Retur Penjualan</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @if (Session::get('jenis') === "admin")
                        <li class="nav-item">
                            <a href="{{url('penanaman_modal/')}}" class="nav-link {{ Request::is('penanaman_modal') || Request::is('penanaman_modal/*') ? 'active' : '' }}">
                                <i class="nav-icon far fa-money-bill-alt"></i>
                                <p>
                                    Penanaman Modal
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{url('aset/')}}" class="nav-link {{ Request::is('aset') || Request::is('aset/*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-building"></i>
                                <p>
                                    Aset
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{url('beban/')}}" class="nav-link {{ Request::is('beban') || Request::is('beban/*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-bolt"></i>
                                <p>
                                    Beban
                                </p>
                            </a>
                        </li>
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link {{ Request::is('pelanggan') || Request::is('pelanggan/*') ? 'active' : '' }} {{ Request::is('supplier') || Request::is('supplier/*') ? 'active' : '' }} {{ Request::is('karyawan') || Request::is('karyawan/*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    Stakeholder
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{url('pelanggan/')}}" class="nav-link {{ Request::is('pelanggan') || Request::is('pelanggan/*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Pelanggan</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{url('supplier/')}}" class="nav-link {{ Request::is('supplier') || Request::is('supplier/*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Supplier</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{url('karyawan/')}}" class="nav-link {{ Request::is('karyawan') || Request::is('karyawan/*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Karyawan</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link {{ Request::is('jurnal_penutup') || Request::is('jurnal_penutup/*') ? 'active' : '' }} {{ Request::is('jurnal_penyesuaian') || Request::is('jurnal_penyesuaian/*') ? 'active' : '' }} {{ Request::is('jurnal_umum') || Request::is('jurnal_umum/*') ? 'active' : '' }} {{ Request::is('jurnal_kas_keluar') || Request::is('jurnal_kas_keluar/*') ? 'active' : '' }} {{ Request::is('jurnal_kas_masuk') || Request::is('jurnal_kas_masuk/*') ? 'active' : '' }} {{ Request::is('jurnal_pembelian') || Request::is('jurnal_pembelian/*') ? 'active' : ''}} {{ Request::is('jurnal_penjualan') || Request::is('jurnal_penjualan/*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-book-open"></i>
                                <p>
                                    Jurnal
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{url('jurnal_pembelian/')}}" class="nav-link {{ Request::is('jurnal_pembelian') || Request::is('jurnal_pembelian/*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Jurnal Pembelian</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{url('jurnal_penjualan/')}}" class="nav-link {{ Request::is('jurnal_penjualan') || Request::is('jurnal_penjualan/*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Jurnal Penjualan</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{url('jurnal_kas_masuk')}}" class="nav-link {{ Request::is('jurnal_kas_masuk') || Request::is('jurnal_kas_masuk/*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Jurnal Penerimaan Kas</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{url('jurnal_kas_keluar')}}" class="nav-link {{ Request::is('jurnal_kas_keluar') || Request::is('jurnal_kas_keluar/*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Jurnal Pengeluaran Kas</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{url('jurnal_umum')}}" class="nav-link {{ Request::is('jurnal_umum') || Request::is('jurnal_umum/*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Jurnal Umum</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{url('jurnal_penyesuaian')}}" class="nav-link {{ Request::is('jurnal_penyesuaian') || Request::is('jurnal_penyesuaian/*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Jurnal Penyesuaian</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{url('jurnal_penutup')}}" class="nav-link {{ Request::is('jurnal_penutup') || Request::is('jurnal_penutup/*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Jurnal Penutup</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="{{url('buku_besar/')}}" class="nav-link {{ Request::is('buku_besar') || Request::is('buku_besar/*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-book-open"></i>
                                <p>
                                    Buku Besar
                                </p>
                            </a>
                        </li>
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link {{ Request::is('arus_kas') || Request::is('arus_kas/*') ? 'active' : '' }} {{ Request::is('perubahan_modal') || Request::is('perubahan_modal/*') ? 'active' : '' }} {{ Request::is('laba_rugi') || Request::is('laba_rugi/*') ? 'active' : '' }}  {{ Request::is('neraca_saldo') || Request::is('neraca_saldo/*') ? 'active' : '' }} ">
                                <i class="nav-icon far fa-money-bill-alt"></i>
                                <p>
                                    Laporan
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{url('neraca_saldo/')}}" class="nav-link {{ Request::is('neraca_saldo') || Request::is('neraca_saldo/*') ? 'active' : '' }}  ">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Neraca Saldo</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{url('laba_rugi/')}}" class="nav-link {{ Request::is('laba_rugi') || Request::is('laba_rugi/*') ? 'active' : '' }} ">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Laba Rugi</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{url('perubahan_modal/')}}" class="nav-link {{ Request::is('perubahan_modal') || Request::is('perubahan_modal/*') ? 'active' : '' }}  ">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Perubahan Modal</p>
                                    </a>
                                </li>
                            </ul>
                            @endif
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>@yield('title')</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">@yield('title')</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">

                <!-- Default box -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">@yield('judul')</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i></button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                                <i class="fas fa-times"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        @yield('content')
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->

            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->


        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->
    <!-- Modal Tutup Periode-->
    <div id="tutup" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="icon-menu7"></i> &nbsp;Tutup Periode</h5>
                </div>

                <div class="modal-body-logout" style="padding:20px;">
                    <p>Apakah Anda Yakin Ingin Menutup Periode?</p>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal"><i class="icon-cross"></i> Batal</button>
                    <a class="btn btn-primary" href="{{url('tutup_periode/')}}"><i class="icon-switch2"></i> Yakin</a>
                </div>
            </div>
        </div>
    </div>
    <!-- jQuery -->
    <script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{asset('dist/js/adminlte.min.js')}}"></script>
    <!-- Select2 -->
    <script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{asset('dist/js/demo.js')}}"></script>
    <!-- DataTables -->
    <script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
    <!-- InputMask -->
    <script src="{{asset('plugins/moment/moment.min.js')}}"></script>
    <script src="{{asset('plugins/inputmask/min/jquery.inputmask.bundle.min.js')}}"></script>
    <!-- Scripts -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!--Page Script-->
    <script>
        $(function() {
            $("#tabel_debit").DataTable({
                "responsive": true,
                "autoWidth": false,
            });
            $('#faktur').change(function() {
                var selected_value = $(this).val();
                $('#form_id').attr('action', 'retur_pembelian/proses/' + selected_value).attr('method', 'get');
            });
            $('#fakturjual').change(function() {
                var selected_value = $(this).val();
                $('#form_id_rj').attr('action', 'retur_penjualan/proses/' + selected_value).attr('method', 'get');
            });
            $("#tabel_kredit").DataTable({
                "responsive": true,
                "autoWidth": false,
            });
            $("#tabel_product").DataTable({
                "responsive": true,
                "autoWidth": false,
            });
            //Money Euro
            $('[data-mask]').inputmask()

            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })

            //Datemask dd/mm/yyyy
            $('#datemask').inputmask('dd/mm/yyyy', {
                'placeholder': 'dd/mm/yyyy'
            })
            //Datemask2 mm/dd/yyyy
            $('#datemask2').inputmask('mm/dd/yyyy', {
                'placeholder': 'mm/dd/yyyy'
            })
            //Money Euro
            $('[data-mask]').inputmask()

            //Date range picker
            $('#reservationdate').datetimepicker({
                format: 'L'
            });
            //Date range picker
            $('#reservation').daterangepicker()
            //Date range picker with time picker
            $('#reservationtime').daterangepicker({
                timePicker: true,
                timePickerIncrement: 30,
                locale: {
                    format: 'MM/DD/YYYY hh:mm A'
                }
            })
            //Date range as a button
            $('#daterange-btn').daterangepicker({
                    ranges: {
                        'Today': [moment(), moment()],
                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    },
                    startDate: moment().subtract(29, 'days'),
                    endDate: moment()
                },
                function(start, end) {
                    $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
                }
            )

            //Timepicker
            $('#timepicker').datetimepicker({
                format: 'LT'
            })
            //Bootstrap Duallistbox
            $('.duallistbox').bootstrapDualListbox()

            //Colorpicker
            $('.my-colorpicker1').colorpicker()
            //color picker with addon
            $('.my-colorpicker2').colorpicker()

            $('.my-colorpicker2').on('colorpickerChange', function(event) {
                $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
            });

            $("input[data-bootstrap-switch]").each(function() {
                $(this).bootstrapSwitch('state', $(this).prop('checked'));
            });
        });
    </script>
</body>

</html>