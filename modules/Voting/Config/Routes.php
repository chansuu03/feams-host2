<?php

$routes->group('voting2', ['namespace' => 'Modules\Voting\Controllers'], function($routes){
//   $routes->get('/', 'Voting::index');
  $routes->match(['get', 'post'], '/', 'Voting2::index', ["filter" => "auth"]);
  $routes->post('cast', 'Voting2::castVote', ["filter" => "auth"]);
  $routes->match(['get', 'post'], 'elec/(:num)', 'Voting2::other/$1', ["filter" => "auth"]);
});

$routes->group('voting', ['namespace' => 'Modules\Voting\Controllers'], function($routes){
//   $routes->get('/', 'Voting::index');
  $routes->match(['get', 'post'], '/', 'Voting3::index', ["filter" => "auth"]);
  $routes->post('cast', 'Voting3::castVote', ["filter" => "auth"]);
  $routes->match(['get', 'post'], 'elec/(:num)', 'Voting3::other/$1', ["filter" => "auth"]);
});
