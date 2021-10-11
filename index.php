<?php
session_start();
require_once 'vendor/autoload.php';



$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/', 'TodoController@index');
    $r->addRoute('GET', '/todos', 'TodoController@index');
    $r->addRoute('GET', '/create', 'TodoController@create');
    $r->addRoute('POST', '/add', 'TodoController@save');
    $r->addRoute('POST', '/setstatus', 'TodoController@update');
    $r->addRoute('POST', '/delete', 'TodoController@delete');
    $r->addRoute('GET', '/login', 'AuthController@login');
    $r->addRoute('POST', '/checkout', 'AuthController@checkout');
    $r->addRoute('GET', '/logout', 'AuthController@logout');
    $r->addRoute('GET', '/register', 'AuthController@register');
    $r->addRoute('POST', '/registrate', 'AuthController@registrate');
});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        [$controller, $method] = explode('@', $handler);
        if($_SESSION){

            $controller = 'App\Controllers\\' . $controller;
            $controller = new $controller();
            $controller->$method();
            break;

        }
        if($method === 'login' || $method === 'checkout' || $method === 'register' || $method === 'registrate'){
            $controller = 'App\Controllers\\' . $controller;
            $controller = new $controller();
            $controller->$method();
            break;
        }
        $controller = 'App\Controllers\\' . 'AuthController';
        $controller = new $controller();
        $controller->login();
        break;

}