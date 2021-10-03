<?php

$routes->group('admin/dashboard', ['namespace' => 'Modules\Dashboard\Controllers'], function($routes){
    $routes->get('/', 'Dashboard::index', ["filter" => "auth"]);
});
