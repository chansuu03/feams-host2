<?php

$routes->group('admin/contributions', ['namespace' => 'Modules\Contributions\Controllers'], function($routes){
  $routes->get('/', 'Contributions::index', ["filter" => "auth"]);
  $routes->match(['get', 'post'], 'add', 'Contributions::add', ["filter" => "auth"]);
  $routes->match(['get', 'post'], 'edit/(:num)', 'Contributions::edit/$1');
  $routes->get('delete/(:num)', 'Contributions::delete/$1');
  $routes->get('print/(:num)', 'Contributions::print/$1');
});
