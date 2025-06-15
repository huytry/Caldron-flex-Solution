<?php

namespace Config;

$routes = Services::routes();

$routes->get('warehouse', 'Warehouse::index', ['namespace' => 'Warehouse\Controllers']);
$routes->get('warehouse/(:any)', 'Warehouse::$1', ['namespace' => 'Warehouse\Controllers']);

$routes->post('warehouse/(:any)', 'Warehouse::$1', ['namespace' => 'Warehouse\Controllers']);


