<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

// Корневой маршрут
$router->get('/', function () use ($router) {
    return $router->app->version();
});

// Маршруты, требующие аутентификации
$router->group(['prefix' => 'api/', 'middleware' => 'auth:api'], function () use ($router) {
    // Транзакции
    $router->post('transactions/{action}/{productId}', 'TransactionController@processTransaction');
    // Пополнение баланса
    $router->post('/transfer-money', 'UserController@transferMoney');
    // Получение списка транзакций
    $router->post('/get-transactions', 'UserController@getTransactions');
});

// Список продуктов
$router->get('products-list', 'ProductController@showProducts');

// Аутентификация
$router->group(['prefix' => 'auth'], function () use ($router) {
    $router->post('/register', 'AuthController@register');
    $router->post('/login', 'AuthController@login');
});

