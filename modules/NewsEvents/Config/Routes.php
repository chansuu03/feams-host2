<?php

$routes->group('admin/news', ['namespace' => 'Modules\NewsEvents\Controllers'], function($routes){
  $routes->get('/', 'NewsEvents::index', ["filter" => "auth"]);
  $routes->match(['get', 'post'], 'add', 'NewsEvents::add', ["filter" => "auth"]);
  $routes->match(['get', 'post'], 'edit/(:num)', 'NewsEvents::edit/$1');
  $routes->get('delete/(:num)', 'NewsEvents::delete/$1');
});

$routes->get('news/(:num)', '\Modules\NewsEvents\Controllers\NewsEvents::view/$1');
$routes->get('news', '\Modules\NewsEvents\Controllers\NewsEvents::newsList');
