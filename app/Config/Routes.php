<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Routing\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes = Services::routes();

$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

// API routes
$routes->group('api', static function ($routes) {
    $routes->post('auth/register', 'AuthController::register');
    $routes->post('auth/login', 'AuthController::login');

    // Protected
    $routes->get('users', 'AuthController::listUsers', ['filter' => 'jwt']);
    $routes->get('teachers', 'TeacherController::index', ['filter' => 'jwt']);
    $routes->post('teachers', 'TeacherController::create', ['filter' => 'jwt']);
});
