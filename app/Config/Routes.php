<?php

namespace Config;

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('belanja', 'Home::shop');
$routes->get('keranjang', 'Home::keranjang');
