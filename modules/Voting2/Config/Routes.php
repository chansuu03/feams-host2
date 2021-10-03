<?php

$routes->group('votes', ['namespace' => 'Modules\Voting2\Controllers'], function($routes){
//   $routes->get('/', 'Voting::index');
  $routes->match(['get', 'post'], '/', 'Voting::index', ["filter" => "auth"]);
  $routes->post('cast', 'Voting::castVote', ["filter" => "auth"]);
  $routes->match(['get', 'post'], 'elec/(:num)', 'Voting::other/$1', ["filter" => "auth"]);
});

$routes->group('votes2', ['namespace' => 'Modules\Voting2\Controllers'], function($routes){
//   $routes->get('/', 'Voting::index');
  $routes->match(['get', 'post'], '/', 'Voting2::index', ["filter" => "auth"]);
  $routes->post('cast', 'Voting2::cast', ["filter" => "auth"]);
  $routes->get('elec/(:num)', 'Voting2::other/$1', ["filter" => "auth"]);
});