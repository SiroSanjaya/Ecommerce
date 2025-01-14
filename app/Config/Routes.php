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
$routes->get('/admin/dashboard', 'DashboardController::index');

