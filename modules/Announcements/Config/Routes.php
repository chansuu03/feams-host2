<?php

$routes->group('admin/announcements', ['namespace' => 'Modules\Announcements\Controllers'], function($routes){
  $routes->get('/', 'Announcements::index', ["filter" => "auth"]);
  $routes->match(['get', 'post'], 'add', 'Announcements::add', ["filter" => "auth"]);
  $routes->match(['get', 'post'], 'edit/(:alphanum)', 'Announcements::edit/$1');
  $routes->get('delete/(:alphanum)', 'Announcements::delete/$1');
  $routes->get('pdf', 'Announcements::generatePDF');
});

$routes->get('announcements/(:alphanum)', '\Modules\Announcements\Controllers\Announcements::info/$1');
$routes->get('announcements', '\Modules\Announcements\Controllers\Announcements::forMembers/$1');