<?php

$routes->group('admin/permissions', ['namespace' => 'Modules\Permissions\Controllers'], function($routes){
  $routes->get('/', 'Permissions::index', ["filter" => "auth"]);
  // $routes->match(['get', 'post'], 'add', 'Permissions::add', ["filter" => "auth"]);
  $routes->match(['get', 'post'], 'edit/(:num)', 'Permissions::add/$1', ["filter" => "auth"]);
});
