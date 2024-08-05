<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');


$routes->group('OperatorLogin', function (RouteCollection $routes) {
  $routes->get('/', 'OperatorLogin::index');
});

$routes->group('CustomerAuth', function (RouteCollection $routes) {
  $routes->get('/', 'CustomerAuth::index');
});

$routes->group('OperatorPanel', function (RouteCollection $routes) {
  $routes->get('/', function () {
    return redirect()->to(base_url('OperatorPanel/Profile'));
  });

  $routes->get('Profile', 'OperatorPanel::index');
  $routes->get('Produk', 'OperatorPanel::produk');
  $routes->get('Pelanggan', 'OperatorPanel::pelanggan');
  $routes->get('Kupon', 'OperatorPanel::kupon');
  $routes->get('Transaksi', 'OperatorPanel::transaksi');
  $routes->get('Review', 'OperatorPanel::review');
});

$routes->group('CustomerPanel', function (RouteCollection $routes) {
  $routes->get('/', 'CustomerPanel::index');
});
