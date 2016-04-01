<?php
// https://github.com/PatrickLouys/no-framework-tutorial
$injector = new \Auryn\Injector;

$injector->alias('Http\Response', 'Http\HttpResponse');

$injector->share('Http\HttpRequest');
$injector->define('Http\HttpRequest', [
    ':get' => $_GET,
    ':post' => $_POST,
    ':cookies' => $_COOKIE,
    ':files' => $_FILES,
    ':server' => $_SERVER,
]);

$injector->alias('Http\Request', 'Http\HttpRequest');
$injector->share('Http\HttpResponse');

$injector->delegate('Twig_Environment', function() use ($injector) {
    $loader = new Twig_Loader_Filesystem(dirname(__DIR__) . '/templates');
    $twig = new Twig_Environment($loader, ['debug' => true]);
    $twig->addExtension(new Twig_Extension_Debug());
    return $twig;
});

$injector->alias('Fotheby\Template\View', 'Fotheby\Template\TwigRenderer');

return $injector;
// https://github.com/PatrickLouys/no-framework-tutorial