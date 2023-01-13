<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::resource('login', 'LoginController');
Route::resource('/', 'LoginController');

Route::resource('dashboard', 'DashboardController');

//retur pembelian
Route::resource('/retur_pembelian','ReturPembelianController');
Route::get('retur_pembelian/proses/{faktur}', 'ReturPembelianController@proses');
Route::post('retur_pembelian/update', 'ReturPembelianController@update');
Route::get('retur_pembelian/delete/{id}', 'ReturPembelianController@delete');
Route::post('retur_pembelian/add_barang', 'ReturPembelianController@add_barang');
Route::get('retur_pembelian/detail/{id}', 'ReturPembelianController@detail');

//retur penjualan
Route::resource('/retur_penjualan','ReturPenjualanController');
Route::get('retur_penjualan/proses/{faktur}', 'ReturPenjualanController@proses');
Route::post('retur_penjualan/update', 'ReturPenjualanController@update');
Route::get('retur_penjualan/delete/{id}', 'ReturPenjualanController@delete');
Route::post('retur_penjualan/add_barang', 'ReturPenjualanController@add_barang');
Route::get('retur_penjualan/detail/{id}', 'ReturPenjualanController@detail');


//akun
Route::resource('/akun', 'AkunController');
Route::post('/akun/add_periode', 'AkunController@add_periode');
Route::post('/akun/add_akun', 'AkunController@store');
Route::get('/akun/delete/{id}', 'AkunController@delete');

//akun periode
Route::resource('/akunSaldo', 'AkunSaldoController');
Route::get('akunSaldo/delete/{id}', 'AkunSaldoController@delete');
Route::post('akunSaldo/update', 'AkunSaldoController@update');
Route::post('akunSaldo/kunci', 'AkunSaldoController@kunci');

//barang
Route::resource('/barang', 'BarangController');
Route::get('barang/delete/{id}', 'BarangController@delete');
Route::post('barang/update', 'BarangController@update');

//Modal
Route::resource('/penanaman_modal', 'ModalController');
Route::post('/modal.store', 'ModalController@store');
//aset
Route::resource('/aset', 'AsetController');
Route::get('aset/delete/{id}', 'AsetController@delete');
Route::post('aset/update', 'AsetController@update');

//beban
Route::resource('/beban', 'BebanController');
Route::get('beban/delete/{id}', 'BebanController@delete');
Route::post('beban/update', 'BebanController@update');

//pelanggan
Route::resource('/pelanggan', 'PelangganController');
Route::get('pelanggan/delete/{id}', 'PelangganController@delete');
Route::post('pelanggan/update', 'PelangganController@update');

//periode
Route::resource('/periode', 'PeriodeController');
Route::get('/tutup_periode', 'PeriodeController@tutup_periode');

//supplier
Route::resource('/supplier', 'SupplierController');
Route::get('supplier/delete/{id}', 'SupplierController@delete');
Route::post('supplier/update', 'SupplierController@update');

//karyawan
Route::resource('/karyawan', 'KaryawanController');
Route::get('karyawan/delete/{id}', 'KaryawanController@delete');
Route::post('karyawan/update', 'KaryawanController@update');

//pembelian
Route::resource('/pembelian', 'PembelianController');
Route::get('pembelian/delete/{id}', 'PembelianController@delete');
Route::post('pembelian/update', 'PembelianController@update');
Route::post('pembelian/add_barang', 'PembelianController@add_barang');
Route::get('pembelian/detail/{id}', 'PembelianController@read_by_faktur');
Route::post('pembelian/bayar', 'PembelianController@bayar');

//jurnal pembelian
Route::resource('/jurnal_pembelian', 'JurnalPembelianController');
Route::post('/jurnal_pembelian/search', 'JurnalPembelianController@search');

//jurnal penutup
Route::resource('/jurnal_penutup', 'JurnalPenutupController');
Route::post('/jurnal_penutup/search', 'JurnalPenutupController@search');

//jurnal kas keluar
Route::resource('/jurnal_kas_keluar', 'JurnalKasKeluarController');
Route::post('/jurnal_kas_keluar/search', 'JurnalKasKeluarController@search');
Route::post('/jurnal_kas_keluar/print', 'JurnalKasKeluarController@print');

//jurnal kas masuk
Route::resource('/jurnal_kas_masuk', 'JurnalKasMasukController');
Route::post('/jurnal_kas_masuk/search', 'JurnalKasMasukController@search');

//jurnal penjualan
Route::resource('/jurnal_penjualan', 'JurnalPenjualanController');
Route::post('/jurnal_penjualan/search', 'JurnalPenjualanController@search');

//buku besar
Route::resource('/buku_besar', 'BukuBesarController');
Route::post('/buku_besar/search', 'BukuBesarController@search');

//jurnal umum
Route::resource('/jurnal_umum', 'JurnalUmumController');
Route::post('/jurnal_umum/search', 'JurnalUmumController@search');

//neraca saldo
Route::resource('/neraca_saldo', 'NeracaSaldoController');
Route::post('/neraca_saldo/search', 'NeracaSaldoController@search');

//jurnal penyesuaian
Route::resource('/jurnal_penyesuaian', 'JurnalPenyesuaianController');
Route::post('/jurnal_penyesuaian/search', 'JurnalPenyesuaianController@search');

//labarugi
Route::resource('/laba_rugi', 'LabaRugiController');
Route::post('/laba_rugi/search', 'LabaRugiController@search');

//perubahan modal
Route::resource('/perubahan_modal', 'PerubahanModalController');
Route::post('/perubahan_modal/search', 'PerubahanModalController@search');

//penjualan
Route::resource('/penjualan', 'PenjualanController');
Route::get('penjualan/delete/{id}', 'PenjualanController@delete');
Route::post('penjualan/update', 'PenjualanController@update');
Route::post('penjualan/add_barang', 'PenjualanController@add_barang');
Route::get('penjualan/detail/{id}', 'PenjualanController@read_by_faktur');
Route::post('penjualan/bayar', 'PenjualanController@bayar');


//login, logout
Route::resource('login', 'LoginController');
Route::post('loginPost', 'LoginController@loginPost');
Route::get('logout', 'LoginController@logout');
