<?php

$routes->group('constitution', ['namespace' => 'Modules\Constitution\Controllers'], function($routes){
    $routes->get('/', 'Constitution::index', ["filter" => "auth"]);
    $routes->match(['get', 'post'], 'add', 'Constitution::add', ["filter" => "auth"]);
    $routes->match(['get', 'post'], 'edit/(:num)', 'Constitution::edit/$1', ["filter" => "auth"]);
    $routes->get('print', 'Constitution::generatePDF', ["filter" => "auth"]);
    $routes->get('delete/(:num)', 'Constitution::delete/$1', ["filter" => "auth"]);
});
