<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'PagesController::index');
$routes->get('/MarketPlaces', 'PagesController::MarketPlaces');
$routes->get('CategoryProduct/(:num)', 'CategoryProductController::categoryProduct/$1');
$routes->get('/ProductDetail/(:num)', 'ProductDetailController::index/$1');
$routes->get('/Checkout', 'PagesController::Checkout');
$routes->get('/Login', 'PagesController::Login');
$routes->get('auth/login', 'AuthController::login');
$routes->get('auth/callback', 'AuthController::callback');


$routes->group('admin', ['namespace' => 'App\Controllers'], function ($routes) {
    $routes->get('dashboard', 'DashboardController::index');
    $routes->get('Product', 'ProductAdminController::index');
    $routes->get('product/create', 'ProductAdminController::create');
    $routes->post('product/store', 'ProductAdminController::store');
    $routes->get('product/edit/(:num)', 'ProductAdminController::edit/$1');
    $routes->post('product/update/(:num)', 'ProductAdminController::update/$1');
    $routes->get('product/delete/(:num)', 'ProductAdminController::delete/$1');
});