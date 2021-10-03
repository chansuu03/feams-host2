<?php

// $routes->group('admin/elections', ['namespace' => 'Modules\Elections\Controllers'], function($routes){
//   $routes->get('/', 'Elections2::index', ["filter" => "auth"]);
//   $routes->match(['get', 'post'], 'add', 'Elections2::add2', ["filter" => "auth"]);
//   $routes->match(['get', 'post'], 'edit/(:num)', 'Elections2::edit/$1', ["filter" => "auth"]);
//   $routes->get('delete/(:num)', 'Elections2::deactivate/$1', ["filter" => "auth"]);
//   $routes->get('(:num)', 'Elections2::info2/$1', ["filter" => "auth"]);
// //   $routes->get('(:num)/pdf', 'Elections2::generatePDF/$1', ["filter" => "auth"]);
//   $routes->get('(:num)/pdf', 'Elections2::pdf/$1', ["filter" => "auth"]);
//   $routes->post('(:num)/set', 'Elections2::saveOfficers/$1', ["filter" => "auth"]);
// });

// $routes->group('admin/candidates', ['namespace' => 'Modules\Elections\Controllers'], function($routes){
//   $routes->get('/', 'Candidates2::index', ["filter" => "auth"]);
//   $routes->match(['get', 'post'], 'add', 'Candidates2::add', ["filter" => "auth"]);
//   $routes->get('delete/(:num)', 'Candidates2::delete/$1', ["filter" => "auth"]);
//   $routes->get('elec/(:num)', 'Candidates2::other/$1', ["filter" => "auth"]);
//   $routes->get('election/(:num)', 'Candidates2::tables/$1', ["filter" => "auth"]);
// });

// $routes->group('admin/candidates2', ['namespace' => 'Modules\Elections\Controllers'], function($routes){
//   $routes->get('/', 'Candidates3::index', ["filter" => "auth"]);
//   $routes->match(['get', 'post'], 'add', 'Candidates3::add', ["filter" => "auth"]);
//   $routes->get('delete/(:num)', 'Candidates3::delete/$1', ["filter" => "auth"]);
//   $routes->get('elec/(:num)', 'Candidates3::other/$1', ["filter" => "auth"]);
//   $routes->get('election/(:num)', 'Candidates3::tables/$1', ["filter" => "auth"]);
// });

// $routes->group('admin/positions', ['namespace' => 'Modules\Elections\Controllers'], function($routes){
//   $routes->get('/', 'Positions3::index', ["filter" => "auth"]);
//   $routes->match(['get', 'post'], 'add', 'Positions2::add', ["filter" => "auth"]);
//   $routes->get('delete/(:num)', 'Positions2::delete/$1', ["filter" => "auth"]);
//   $routes->get('elec/(:num)', 'Positions2::other/$1', ["filter" => "auth"]);
//   $routes->match(['get', 'post'], 'edit/(:num)', 'Positions3::edit/$1', ["filter" => "auth"]);
// });

// $routes->group('admin/electoral-positions', ['namespace' => 'Modules\Elections\Controllers'], function($routes){
//   $routes->get('/', 'ElectoralPositions::index', ["filter" => "auth"]);
//   $routes->match(['get', 'post'], 'add', 'ElectoralPositions::add', ["filter" => "auth"]);
//   $routes->match(['get', 'post'], 'edit/(:alphanum)', 'ElectoralPositions::edit/$1', ["filter" => "auth"]);
//   $routes->get('delete/(:num)', 'ElectoralPositions::delete/$1', ["filter" => "auth"]);
//   $routes->get('elec/(:num)', 'Positions2::other/$1', ["filter" => "auth"]);
// });
