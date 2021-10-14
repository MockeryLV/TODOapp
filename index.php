<?php
session_start();
require_once 'vendor/autoload.php';

use Twig\Environment;
use Twig\Loader\ArrayLoader;




$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/', 'TodoController@index');
    $r->addRoute('GET', '/todos', 'TodoController@index');
    $r->addRoute('GET', '/create', 'TodoController@create');
    $r->addRoute('POST', '/add', 'TodoController@save');
    $r->addRoute('POST', '/setstatus', 'TodoController@update');
    $r->addRoute('POST', '/delete', 'TodoController@delete');
    $r->addRoute('GET', '/login', 'UsersController@login');
    $r->addRoute('POST', '/verify', 'UsersController@verify');
    $r->addRoute('GET', '/logout', 'UsersController@logout');
    $r->addRoute('GET', '/register', 'UsersController@register');
    $r->addRoute('POST', '/registrate', 'UsersController@registrate');
    $r->addRoute('GET', '/edit', 'TodoController@showEdit');
    $r->addRoute('POST', '/edit', 'TodoController@edit');
    $r->addRoute('GET', '/settings', 'UsersController@showEdit');
    $r->addRoute('POST', '/settings', 'UsersController@edit');

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
            $response = $controller->$method();
            if($response instanceof \App\Models\View){
                \App\TwigRenderer::render($response->getPath(), $response->getVars());
            }
            break;

        }
        if($method === 'login' || $method === 'verify' || $method === 'register' || $method === 'registrate'){
            $controller = 'App\Controllers\\' . $controller;
            $controller = new $controller();
            $response = $controller->$method();
            if($response instanceof \App\Models\View){
                \App\TwigRenderer::render($response->getPath(), $response->getVars());
            }
            break;
        }
        $controller = 'App\Controllers\\' . 'UsersController';
        $controller = new $controller();
        $response = $controller->login();
        if($response instanceof \App\Models\View){
            \App\TwigRenderer::render($response->getPath(), $response->getVars());
        }
        break;

}