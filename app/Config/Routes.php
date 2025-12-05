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
    $routes->post('add', 'Api\Basket::add');
    $routes->post('delete', 'Api\Basket::removeItem');
    $routes->post('purchase', 'Api\Basket::purchase');
    
    // Optional: GET methods
    $routes->get('list', 'Api\Basket::list');
    $routes->get('total', 'Api\Basket::total');
});



// Admin routes untuk autentikasi 
$routes->group('admin', function($routes) {
    
    $routes->post('login','Api\AdminAuth::login');
    $routes->get('login','Dashboard::adminlogin');
    
    $routes->post('register','Api\AdminAuth::register');
    $routes->get('register','Dashboard::adminregister');
    
    $routes->get('logout','Api\AdminAuth::logout'); 


    
    
    $routes->get('dashboard','Dashboard::admin');
    $routes->get('order/view','Dashboard::adminpesanan');
    $routes->get('transaction/view','Dashboard::admintransaksi');
    $routes->get('finance/view','Dashboard::adminkeuangan');
    $routes->get('product/view','Dashboard::adminproduk');
    
    
});

// $routes->get('admin','Home::admin');
// Admin Routes dengan filter JWT
$routes->group('admin', ['filter' => 'jwt'], function($routes) {
    
    $routes->get('/','Api\Dashboard::admin');
    $routes->get('order','Api\Dashboard::adminpesanan');
    $routes->get('transaction','Api\Dashboard::admintransaksi');
    $routes->get('finance','Api\Dashboard::adminkeuangan');
    $routes->get('product','Api\Dashboard::adminproduk');

    
});
