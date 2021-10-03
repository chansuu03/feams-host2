<?php

$routes->group('files', ['namespace' => 'Modules\Files\Controllers'], function($routes){
  $routes->get('/', 'Files::index', ["filter" => "auth"]);
  $routes->match(['get', 'post'], 'add', 'Files::add');
  $routes->match(['get', 'post'], 'edit/(:alphanum)', 'Files::edit/$1');
  $routes->get('delete/(:num)', 'Files::delete/$1');
});

$routes->group('files/categories', ['namespace' => 'Modules\Files\Controllers'], function($routes){
  $routes->get('/', 'FileCategories::index', ["filter" => "auth"]);
  $routes->match(['get', 'post'], 'add', 'FileCategories::add');
  $routes->match(['get', 'post'], 'edit/(:alphanum)', 'Files::edit/$1');
  $routes->get('delete/(:num)', 'FileCategories::delete/$1');
});
