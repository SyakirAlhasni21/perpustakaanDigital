<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->post('/', 'Home::index');
$routes->get('/login', 'Users::index');
$routes->get('/register', 'Users::register');
$routes->get('/logout', 'Users::logout');
$routes->get('/dashboard', 'Dashboard::index');
$routes->post('/users/login', 'Users::login');
$routes->post('/users/save', 'Users::save');
$routes->post('/add-to-cart', 'Cart::addToCart');
$routes->post('/remove-from-cart', 'Cart::removeFromCart');
$routes->get('/cart', 'Cart::index');
$routes->post('/cart/updateQuantity', 'Cart::updateQuantity');
$routes->post('/cart/remove', 'Cart::remove');
$routes->post('/checkout', 'Cart::checkout');
$routes->group('buku', ['namespace' => 'App\Controllers'], function ($routes) {
    $routes->get('/', 'Buku::index'); // Display the list of books
    $routes->get('create', 'Buku::create'); // Form to add a new book
    $routes->post('store', 'Buku::store'); // Process adding a new book
    $routes->get('edit/(:num)', 'Buku::edit/$1'); // Form to edit a book
    $routes->put('update/(:num)', 'Buku::update/$1'); // Process updating a book
    $routes->delete('(:num)', 'Buku::delete/$1'); // Delete a book
});
$routes->get('transaksi', 'Transaksi::index');
