<?php

$routes->group('admin/users', ['namespace' => 'Modules\Users\Controllers'], function($routes){
  $routes->get('/', 'Users::index', ["filter" => "auth"]);
  $routes->match(['get', 'post'], 'add', 'Roles::add', ["filter" => "auth"]);
  $routes->match(['get', 'post'], 'edit/(:alphanum)', 'Roles::edit/$1', ["filter" => "auth"]);
  $routes->get('delete/(:num)', 'Users::delete/$1', ["filter" => "auth"]);
  $routes->post('csv', 'Users::importcsv', ["filter" => "auth"]);
});

$routes->post('status/(:alphanum)', '\Modules\Users\Controllers\Users::changeStatus/$1', ["filter" => "auth"]);
$routes->post('role/(:alphanum)', '\Modules\Users\Controllers\Users::changeRole/$1', ["filter" => "auth"]);