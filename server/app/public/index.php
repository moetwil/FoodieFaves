<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");

error_reporting(E_ALL);
ini_set("display_errors", 1);

require __DIR__ . '/../vendor/autoload.php';

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Create Router instance
$router = new \Bramus\Router\Router();

$router->setNamespace('Controllers');

// routes for the products endpoint
// $router->get('/products', 'ProductController@getAll');
// $router->get('/products/(\d+)', 'ProductController@getOne');
// $router->post('/products', 'ProductController@create');
// $router->put('/products/(\d+)', 'ProductController@update');
// $router->delete('/products/(\d+)', 'ProductController@delete');

// routes for the categories endpoint
// $router->get('/categories', 'CategoryController@getAll');
// $router->get('/categories/(\d+)', 'CategoryController@getOne');
// $router->post('/categories', 'CategoryController@create');
// $router->put('/categories/(\d+)', 'CategoryController@update');
// $router->delete('/categories/(\d+)', 'CategoryController@delete');

// routes for the users endpoint
$router->post('/users/login', 'UserController@login');
$router->post('/users/register', 'UserController@register');

// Run it!
$router->run();