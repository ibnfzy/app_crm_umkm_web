<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('Katalog', 'Home::katalog');
$routes->get('Katalog/(:num)', 'Home::detail/$1');

$routes->get('Cart', 'Home::cart');
$routes->get('Cart/Delete/(:segment)', 'Home::remove_barang/$1');
$routes->get('Cart/Clear', 'Home::clear_cart');
$routes->post('Cart/Update', 'Home::update_cart');
$routes->post('Cart/Add', 'Home::add_barang');
$routes->post('Cart/ApplyVoucher', 'Home::useKupon');

$routes->post('Search', 'Home::search');

$routes->get('Informasi', 'Home::informasi');
$routes->get('Testimoni', 'Home::testimoni');

$routes->group('OperatorLogin', function (RouteCollection $routes) {
  $routes->get('/', 'OperatorLogin::index');
  $routes->post('Auth', 'OperatorLogin::auth');
  $routes->get('Logoff', 'OperatorLogin::logoff');
});

$routes->group('CustomerAuth', function (RouteCollection $routes) {
  $routes->get('/', 'CustomerAuth::index');
  $routes->get('Register', 'CustomerAuth::register');
  $routes->post('/', 'CustomerAuth::auth');
  $routes->get('Logoff', 'CustomerAuth::logout');
  $routes->post('Register', 'CustomerAuth::register_action');
});

$routes->group('OperatorPanel', function (RouteCollection $routes) {
  $routes->get('/', function () {
    return redirect()->to(base_url('OperatorPanel/Profile'));
  });

  $routes->get('Profile', 'OperatorPanel::index');
  $routes->post('Informasi', 'OperatorPanel::informasi_edit');
  $routes->post('Password', 'OperatorPanel::password_edit');

  $routes->get('Produk', 'OperatorPanel::produk');
  $routes->post('Produk', 'OperatorPanel::produk_add');
  $routes->post('Produk/edit', 'OperatorPanel::produk_edit');
  $routes->get('Produk/(:num)', 'OperatorPanel::produk_delete/$1');
  $routes->get('manage_images/(:num)', 'OperatorPanel::produk_get_images/$1');
  $routes->get('delete_image/(:num)', 'OperatorPanel::produk_delete_single_image/$1');
  $routes->post('upload_images', 'OperatorPanel::produk_add_images');
  $routes->get('Produk/Laporan/(:num)', 'OperatorPanel::get_pdf_laporan_produk/$1');

  $routes->get('Pelanggan', 'OperatorPanel::pelanggan');
  $routes->get('Pelanggan/(:segment)', 'OperatorPanel::pelanggann_detail/$1');
  $routes->get('Kupon', 'OperatorPanel::kupon');
  $routes->post('Kupon', 'OperatorPanel::kupon_add');
  $routes->post('Kupon/edit', 'OperatorPanel::kupon_edit');
  $routes->get('Kupon/(:num)', 'OperatorPanel::kupon_delete/$1');

  $routes->post('Laporan/Bulanan', 'OperatorPanel::laporan_bulanan');

  $routes->get(
    'Invoice/Laporan/(:num)',
    'CustomerPanel::print_invoice/$1'
  );
  $routes->get('Transaksi', 'OperatorPanel::transaksi');
  $routes->get('Invoice/(:num)', 'OperatorPanel::invoice/$1');
  $routes->post('Validasi', 'OperatorPanel::validasi');
  $routes->post('Proses', 'OperatorPanel::proses');
  $routes->get('Review', 'OperatorPanel::review');

  $routes->get('Ongkos_kirim', 'OperatorPanel::ongkir');
  $routes->post('Ongkos_kirim', 'OperatorPanel::ongkir_add');
  $routes->post('Ongkos_kirim/edit', 'OperatorPanel::ongkir_edit');
  $routes->get('Ongkos_kirim/(:num)', 'OperatorPanel::ongkir_delete/$1');

  $routes->get('Slider', 'OperatorPanel::slider');
  $routes->post('Slider', 'OperatorPanel::slider_add');
  $routes->post('Slider/edit', 'OperatorPanel::slider_edit');
  $routes->get('Slider/(:num)', 'OperatorPanel::slider_delete/$1');
});

$routes->group('CustomerPanel', function (RouteCollection $routes) {
  $routes->get('/', function () {
    return redirect()->to(base_url('CustomerPanel/Profile'));
  });

  $routes->get('Profile', 'CustomerPanel::index');
  $routes->get('Orderan', 'CustomerPanel::orderan');
  $routes->get('Review', 'CustomerPanel::review');
  $routes->post('Review', 'CustomerPanel::review_add');
  $routes->get('Review/(:num)', 'CustomerPanel::review_delete/$1');

  $routes->get('Invoice/Laporan/(:num)', 'CustomerPanel::print_invoice/$1');
  $routes->get('Invoice/(:num)', 'CustomerPanel::invoice/$1');
  $routes->get('Checkout', 'CustomerPanel::checkout');
  $routes->post('UploadBuktiBayar', 'CustomerPanel::upload_bukti');
  $routes->post('Konfirmasi', 'CustomerPanel::konfirmasi_pesanan');
  $routes->post('Informasi', 'CustomerPanel::informasi_edit');
  $routes->post('Password', 'CustomerPanel::password_edit');

  $routes->get('Kupon', 'CustomerPanel::kupon');
});
