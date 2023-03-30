<?php
/**
 * Front controller for the application.
 *
 * PHP version 7.4
 *
 * @category Application
 * @package  Core
 */

/**
 * Composer
 */
require '../vendor/autoload.php';

/**
 * Error and Exception handling
 *
 * @throws \Exception
 */
error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');

session_start();

/**
 * Routing
 */
$router = new Core\Router();

// Add the routes
$router->add('', ['controller' => 'Home', 'action' => 'index']);

// Login page
$router->add('Login', ['controller' => 'Login', 'action' => 'new']);

// Generic route for controller and action
$router->add('{controller}/{action}');

// Route for controller, id and action
$router->add('{controller}/{id:\d+}/{action}');

// Admin route for controller and action
$router->add('admin/{controller}/{action}', ['namespace' => 'Admin']);

// Dispatch the route
$router->dispatch($_SERVER['QUERY_STRING']);

?>