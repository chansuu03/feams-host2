<?php

$routes->group('payments', ['namespace' => 'Modules\Payments\Controllers'], function($routes){
  $routes->get('/', 'Payments::index', ["filter" => "auth"]);
  $routes->match(['get', 'post'], 'add', 'Payments::add', ["filter" => "auth"]);
  $routes->match(['get', 'post'], 'admin/add', 'Payments::adminAdd', ["filter" => "auth"]);
  $routes->match(['get', 'post'], 'edit/(:num)', 'Payments::edit/$1');
  $routes->get('delete/(:num)', 'Payments::delete/$1');
  $routes->get('contri/(:num)', 'Payments::contriTable/$1');
  $routes->get('approve/(:num)', 'Payments::approve/$1');
  $routes->get('decline/(:num)', 'Payments::decline/$1');
  $routes->post('feedback', 'Payments::feedback');
});

$routes->get('admin/payment-feedbacks', '\Modules\Payments\Controllers\Payments::adminFeedback', ["filter" => "auth"]);