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

  $routes->get('Produk/AddSingleImage', 'OperatorPanel::produk_add_single_image');
  $routes->get('Produk/DeleteSingleImage/(:num)', 'OperatorPanel::produk_delete_single_image/$1');

  $routes->get('Pelanggan', 'OperatorPanel::pelanggan');
  $routes->get('Kupon', 'OperatorPanel::kupon');
  $routes->get('Transaksi', 'OperatorPanel::transaksi');
  $routes->get('Review', 'OperatorPanel::review');
});

$routes->group('CustomerPanel', function (RouteCollection $routes) {
  $routes->get('/', function () {
    return redirect()->to(base_url('CustomerPanel/Profile'));
  });

  $routes->get('Profile', 'CustomerPanel::index');
  $routes->get('Orderan', 'CustomerPanel::orderan');
  $routes->get('Review', 'CustomerPanel::review');
});
