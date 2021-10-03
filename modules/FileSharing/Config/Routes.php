<?php

$routes->group('file_sharing', ['namespace' => 'Modules\FileSharing\Controllers'], function($routes){
  $routes->get('/', 'FileSharing::index', ["filter" => "auth"]);
  $routes->match(['get', 'post'], 'add', 'FileSharing::add');
  $routes->match(['get', 'post'], 'edit/(:alphanum)', 'FileSharing::edit/$1');
  $routes->get('delete/(:num)', 'FileSharing::delete/$1');
  $routes->get('download/(:num)', 'FileSharing::download/$1');
  $routes->get('generatePDF', 'FileSharing::generatePDF');
});
