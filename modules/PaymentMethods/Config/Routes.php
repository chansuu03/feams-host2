<?php

$routes->group('admin/payment-methods', ['namespace' => 'Modules\PaymentMethods\Controllers'], function($routes){
  $routes->get('/', 'PaymentMethods::index', ["filter" => "auth"]);
  $routes->match(['get', 'post'], 'add', 'PaymentMethods::add', ["filter" => "auth"]);
  $routes->match(['get', 'post'], 'edit/(:num)', 'PaymentMethods::edit/$1');
  $routes->get('delete/(:num)', 'PaymentMethods::delete/$1');
});
