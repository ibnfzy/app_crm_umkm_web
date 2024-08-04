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
  $routes->get('/', 'OperatorPanel::index');
});

$routes->group('CustomerPanel', function (RouteCollection $routes) {
  $routes->get('/', 'CustomerPanel::index');
});
