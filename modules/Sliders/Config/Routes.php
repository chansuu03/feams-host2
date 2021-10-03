<?php

$routes->group('admin/sliders', ['namespace' => 'Modules\Sliders\Controllers'], function($routes){
  $routes->get('/', 'Sliders::index', ["filter" => "auth"]);
  $routes->match(['get', 'post'], 'add', 'Sliders::add', ["filter" => "auth"]);
  $routes->match(['get', 'post'], 'edit/(:num)', 'Sliders::edit/$1');
  $routes->get('delete/(:num)', 'Sliders::delete/$1');
});
