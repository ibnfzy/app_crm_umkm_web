<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('Katalog', 'Home::katalog');
$routes->get('Katalog/(:num)', 'Home::detail/$1');
$routes->get('Cart', 'Home::cart');


$routes->group('OperatorLogin', function (RouteCollection $routes) {
  $routes->get('/', 'OperatorLogin::index');
  $routes->post('Auth', 'OperatorLogin::auth');
  $routes->get('Logoff', 'OperatorLogin::logoff');
});

$routes->group('CustomerAuth', function (RouteCollection $routes) {
  $routes->get('/', 'CustomerAuth::index');
  $routes->get('Register', 'CustomerAuth::register');
});

$routes->group('OperatorPanel', function (RouteCollection $routes) {
  $routes->get('/', function () {
    return redirect()->to(base_url('OperatorPanel/Profile'));
  });

  $routes->get('Profile', 'OperatorPanel::index');

  $routes->get('Produk', 'OperatorPanel::produk');
  $routes->post('Produk', 'OperatorPanel::produk_add');
  $routes->post('Produk/edit', 'OperatorPanel::produk_edit');
  $routes->get('Produk/(:num)', 'OperatorPanel::produk_delete/$1');
  $routes->get('manage_images/(:num)', 'OperatorPanel::produk_get_images/$1');
  $routes->get('delete_image/(:num)', 'OperatorPanel::produk_delete_single_image/$1');
  $routes->post('upload_images', 'OperatorPanel::produk_add_images');

  $routes->get('Pelanggan', 'OperatorPanel::pelanggan');
  $routes->get('Kupon', 'OperatorPanel::kupon');
  $routes->post('Kupon', 'OperatorPanel::kupon_add');
  $routes->post('Kupon/edit', 'OperatorPanel::kupon_edit');
  $routes->get('Kupon/(:num)', 'OperatorPanel::kupon_delete/$1');

  $routes->get('Transaksi', 'OperatorPanel::transaksi');
  $routes->get('Review', 'OperatorPanel::review');

  $routes->get('Ongkos_kirim', 'OperatorPanel::ongkir');
  $routes->post('Ongkos_kirim', 'OperatorPanel::ongkir_add');
  $routes->post('Ongkos_kirim/edit', 'OperatorPanel::ongkir_edit');
  $routes->get('Ongkos_kirim/(:num)', 'OperatorPanel::ongkir_delete/$1');
});

$routes->group('CustomerPanel', function (RouteCollection $routes) {
  $routes->get('/', function () {
    return redirect()->to(base_url('CustomerPanel/Profile'));
  });

  $routes->get('Profile', 'CustomerPanel::index');
  $routes->get('Orderan', 'CustomerPanel::orderan');
  $routes->get('Review', 'CustomerPanel::review');
});
