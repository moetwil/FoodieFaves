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

// Set the namespace for the controllers
$router->setNamespace('Controllers');

# DEFINE ROUTES
// users endpoints
$router->post('/api/users/login', 'UserController@login');
$router->post('/api/users/register', 'UserController@register');
$router->put('/api/users/(\d+)', 'UserController@update');
$router->delete('/api/users/(\d+)', 'UserController@delete');

// restaurants endpoints
$router->post('/api/restaurants', 'RestaurantController@create');
$router->get('/api/restaurants/(\d+)', 'RestaurantController@getById');
$router->get('/api/restaurants', 'RestaurantController@getAll');
$router->get('/api/restaurants/owner/(\d+)', 'RestaurantController@getAllByOwner');
$router->put('/api/restaurants/(\d+)', 'RestaurantController@update');
$router->delete('/api/restaurants/(\d+)', 'RestaurantController@delete');
$router->get('/api/restaurants/(\d+)/reviews', 'RestaurantController@getRestaurantReviewsAmount');
$router->get('/api/restaurants/(\d+)/rating', 'RestaurantController@getRestaurantRating');
$router->get('/api/restaurants/search/(\w+)', 'RestaurantController@search');

// reviews endpoints
$router->post('/api/reviews', 'ReviewController@create');
$router->get('/api/reviews/(\d+)', 'ReviewController@getById');
$router->get('/api/reviews/restaurant/(\d+)', 'ReviewController@getByRestaurant');
$router->get('/api/reviews/user/(\d+)', 'ReviewController@getByUser');
$router->put('/api/reviews/(\d+)', 'ReviewController@update');
$router->delete('/api/reviews/(\d+)', 'ReviewController@delete');
$router->put('/api/reviews/(\d+)/flag', 'ReviewController@flag');
$router->put('/api/reviews/(\d+)/approve', 'ReviewController@approve');


// Run it!
$router->run();