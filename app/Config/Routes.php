<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
// $routes->get('/', 'Home::index', ["filter" => "auth"]);
$routes->get('logout', 'User::logout');
$routes->match(['get', 'post'], 'login', 'Login::index', ["filter" => "noauth"]);
// $routes->match(['get', 'post'], 'login', 'User::login', ["filter" => "noauth"]);
$routes->match(['get', 'post'], 'register', 'Register::index', ["filter" => "noauth"]);
// $routes->match(['get', 'post'], 'register', 'User::register', ["filter" => "noauth"]);
$routes->match(['get', 'post'], 'activate/(:alphanum)', 'User::activate/$1', ["filter" => "noauth"]);
$routes->match(['get', 'post'], 'user/(:alphanum)', '\Modules\Users\Controllers\Users::profile/$1', ["filter" => "auth"]);
$routes->post('user/(:alphanum)/verify', '\Modules\Users\Controllers\Users::changeRole/$1', ["filter" => "auth"]);
// $routes->post('user/edit/(:num)', '\Modules\Users\Controllers\Users::edit/$1', ["filter" => "auth"]);
$routes->post('register/verify', 'Register::verifyPayment', ["filter" => "noauth"]);

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}

// modules
if (file_exists(ROOTPATH.'modules')) {
	$modulesPath = ROOTPATH.'modules/';
	$modules = scandir($modulesPath);

	foreach ($modules as $module) {
		if ($module === '.' || $module === '..') continue;
		if (is_dir($modulesPath) . '/' . $module) {
			$routesPath = $modulesPath . $module . '/Config/Routes.php';
			if (file_exists($routesPath)) {
				require($routesPath);
			} else {
				continue;
			}
		}
	}
}
