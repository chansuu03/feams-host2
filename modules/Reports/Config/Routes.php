<?php

$routes->group('admin/reports', ['namespace' => 'Modules\Reports\Controllers'], function($routes){
    $routes->match(['get', 'post'], 'login', 'LoginReport::index', ["filter" => "auth"]);
    $routes->get('login/table/(:num)', 'LoginReport::changeTable/$1', ["filter" => "auth"]);
    $routes->match(['get', 'post'], 'payments', 'PaymentReport::index', ["filter" => "auth"]);
});
  