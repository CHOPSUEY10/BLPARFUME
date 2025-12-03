<?php

namespace Config;

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::login');

$routes->get('register', 'Auth::register');
$routes->post('register', 'Auth::register');

$routes->get('logout', 'Auth::logout');

$routes->get('belanja', 'Home::shop');
$routes->get('keranjang', 'Home::keranjang');
$routes->get('tentang', 'Home::tentang');
$routes->get('kontak', 'Home::kontak');

// API Routes 
$routes->group('basket/api', function($routes) {
    $routes->post('add', 'Api\BasketApi::add');
    $routes->post('delete', 'Api\BasketApi::removeItem');
    $routes->post('purchase', 'Api\BasketApi::purchase');
    
    // Optional: GET methods
    $routes->get('list', 'Api\BasketApi::list');
    $routes->get('total', 'Api\BasketApi::total');
});

// Admin Routes dengan filter X-Signature
$routes->group('admin/api', function($routes) {
    $routes->get('login'.'Api\AdminAuth::login');
    $routes->post('login'.'Api\AdminAuth::login');
    
    $routes->get('register'.'Api\AdminAuth::register');
    $routes->post('register'.'Api\AdminAuth::register');
    
    
    $routes->get('logout'.'Api\AdminAuth::logout');


});
