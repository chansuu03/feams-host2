<?php

$routes->group('admin/election', ['namespace' => 'Modules\Election\Controllers'], function($routes){
  $routes->get('/', 'Elections::index', ["filter" => "auth"]);
  $routes->match(['get', 'post'], 'add', 'Elections::add', ["filter" => "auth"]);
  $routes->match(['get', 'post'], 'edit/(:num)', 'Elections::edit/$1', ["filter" => "auth"]);
  $routes->get('finish/(:num)', 'Elections::deactivate/$1', ["filter" => "auth"]);
  $routes->get('(:num)', 'Elections::info/$1', ["filter" => "auth"]);
  $routes->get('(:num)/pdf', 'Elections::pdf/$1', ["filter" => "auth"]);
  $routes->post('(:num)/set', 'Elections::saveOfficers/$1', ["filter" => "auth"]);
});

$routes->group('admin/electoral-positions', ['namespace' => 'Modules\Election\Controllers'], function($routes){
  $routes->get('/', 'ElectoralPositions::index', ["filter" => "auth"]);
  $routes->match(['get', 'post'], 'add', 'ElectoralPositions::add', ["filter" => "auth"]);
  $routes->match(['get', 'post'], 'edit/(:alphanum)', 'ElectoralPositions::edit/$1', ["filter" => "auth"]);
  $routes->get('delete/(:num)', 'ElectoralPositions::delete/$1', ["filter" => "auth"]);
//   $routes->get('elec/(:num)', 'Positions2::other/$1', ["filter" => "auth"]);
});

$routes->group('admin/positions', ['namespace' => 'Modules\Election\Controllers'], function($routes){
  $routes->get('/', 'Positions::index', ["filter" => "auth"]);
  $routes->match(['get', 'post'], 'add', 'Positions2::add', ["filter" => "auth"]);
  $routes->get('delete/(:num)', 'Positions2::delete/$1', ["filter" => "auth"]);
  $routes->get('elec/(:num)', 'Positions2::other/$1', ["filter" => "auth"]);
  $routes->match(['get', 'post'], 'edit/(:num)', 'Positions::edit/$1', ["filter" => "auth"]);
});


$routes->group('admin/candidates', ['namespace' => 'Modules\Election\Controllers'], function($routes){
  $routes->get('/', 'Candidates::index', ["filter" => "auth"]);
  $routes->get('election/(:num)', 'Candidates::tables/$1', ["filter" => "auth"]);
  $routes->match(['get', 'post'], 'add', 'Candidates::add', ["filter" => "auth"]);
  $routes->get('delete/(:num)', 'Candidates3::delete/$1', ["filter" => "auth"]);
  $routes->get('elec/(:num)', 'Candidates::other/$1', ["filter" => "auth"]);
});

