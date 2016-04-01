<?php
// following example from:
// https://github.com/PatrickLouys/no-framework-tutorial
namespace Fotheby;

use PDO;
use Fotheby\Util\Session as Session;

require __DIR__ . '/../vendor/autoload.php';

date_default_timezone_set('Europe/London');
error_reporting(E_ALL);

$env = 'dev';

// https://github.com/PatrickLouys/no-framework-tutorial
$whoops = new \Whoops\Run;
if ( $env === 'dev' ) {
  $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
} else {
  $whoops->pushHandler(function($e) {
    echo 'error!';
  });
}
$whoops->register();

// https://github.com/PatrickLouys/no-framework-tutorial
$injector = include('Dependencies.php');
$request = $injector->make('Http\HttpRequest');
$response = $injector->make('Http\HttpResponse');

Session::set('id', 10);

// https://github.com/PatrickLouys/no-framework-tutorial
foreach ($response->getHeaders() as $header) {
    header($header, false);
}

// https://github.com/PatrickLouys/no-framework-tutorial
$routeDefinitionCallback = function (\FastRoute\RouteCollector $r) {
    $routes = include('Routes.php');
    foreach ($routes as $route) {
        $r->addRoute($route[0], $route[1], $route[2]);
    }
};

// https://github.com/PatrickLouys/no-framework-tutorial
$dispatcher = \FastRoute\simpleDispatcher($routeDefinitionCallback);
$routeInfo = $dispatcher->dispatch($request->getMethod(), $request->getPath());

// https://github.com/PatrickLouys/no-framework-tutorial
switch ($routeInfo[0]) {
    case \FastRoute\Dispatcher::NOT_FOUND:
        $response->setContent('404 - Page not found');
        $response->setStatusCode(404);
        break;
    case \FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $response->setContent('405 - Method not allowed');
        $response->setStatusCode(405);
        break;
    case \FastRoute\Dispatcher::FOUND:
        $className = $routeInfo[1][0];
        $method = $routeInfo[1][1];
        $vars = $routeInfo[2];

        $class = $injector->make($className);
        $class->$method($vars);
        break;
}

// https://github.com/PatrickLouys/no-framework-tutorial
echo $response->getContent();
