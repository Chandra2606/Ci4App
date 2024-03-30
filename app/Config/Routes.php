<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/dashboard', 'Dashboard::index');
$routes->get('/laporan', 'Laporan::index');


$routes->group('', ['filter' => 'role:admin'], function($routes) {

    //pelanggan
    $routes->get('/pelanggan', 'Pelanggan::index');
    $routes->get('/pelanggan/view', 'Pelanggan::view');
    $routes->get('/pelanggan/formtambah', 'Pelanggan::formtambah');
    $routes->post('/pelanggan/save', 'Pelanggan::save');
    $routes->post('delete', 'Pelanggan::delete', ['as' => 'pelanggan.delete']);
    $routes->get('pelanggan/edit/(:segment)', 'Pelanggan::formedit/$1', ['as' => 'pelanggan.edit']);
    $routes->put('/pelanggan/update', 'Pelanggan::updatedata');
    $routes->get('pelanggan/detail/(:any)', 'Pelanggan::detail/$1');

    //users
    $routes->get('/user','User::index');
    $routes->get('/user/view', 'User::view');
    $routes->get('user/detail/(:num)', 'User::detail/$1');


});

// $routes->group('', ['filter' => 'role:pimpinan'], function($routes) {
//     $routes->get('/laporan', 'Laporan::index');
// });


