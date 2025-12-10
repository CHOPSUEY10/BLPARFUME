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
$routes->post('kontak', 'Home::sendContact');

// API Routes 
$routes->group('basket/api', function($routes) {
    $routes->post('add', 'Api\Basket::add');
    $routes->post('delete', 'Api\Basket::removeItem');
    $routes->post('purchase', 'Api\Basket::purchase');
    
    // Optional: GET methods
    $routes->get('list', 'Api\Basket::list');
    $routes->get('total', 'Api\Basket::total');
});



// Admin Routes dengan filter admin
$routes->group('admin', ['filter' => 'admin'], function($routes) {
    $routes->get('dashboard','Dashboard::admin');
    $routes->get('order/view','Dashboard::adminpesanan');
    $routes->get('order/export','Dashboard::exportOrders');
    $routes->get('transaction/view','Dashboard::admintransaksi');
    $routes->get('transaction/export','Dashboard::exportTransactions');
    $routes->get('finance/view','Dashboard::adminkeuangan');
    $routes->get('finance/export','Dashboard::exportFinance');
    $routes->get('message/view','Dashboard::adminpesan');
    $routes->post('message/delete/(:num)', 'Dashboard::deleteMessage/$1');
    $routes->get('product/view','Dashboard::adminproduk');
    $routes->get('product/export','Dashboard::exportProducts');
    
    // Product CRUD Routes
    $routes->get('product/create','Dashboard::createProduct');
    $routes->post('product/store','Dashboard::storeProduct');
    $routes->get('product/edit/(:num)','Dashboard::editProduct/$1');
    $routes->post('product/update/(:num)','Dashboard::updateProduct/$1');
    $routes->post('product/delete/(:num)','Dashboard::deleteProduct/$1');
    $routes->delete('product/delete/(:num)','Dashboard::deleteProduct/$1');
    
    // API Routes for admin
    $routes->post('api/order/update-status','Dashboard::updateOrderStatus');
    $routes->post('api/order/create','Dashboard::createOrder');
    $routes->get('api/order/details/(:num)','Dashboard::getOrderDetails/$1');
    $routes->get('api/product/(:num)','Dashboard::getProductDetails/$1');
});


$routes->post('cart/add', 'CartController::addBasket');
$routes->post('cart/update', 'CartController::updateBasket'); // Untuk + dan -
$routes->post('cart/delete', 'CartController::deleteBasket'); // Untuk hapus total

$routes->get('riwayat', 'Home::riwayat');        // Halaman Riwayat
$routes->post('cart/checkout', 'CartController::checkout'); // Proses Simpan Order