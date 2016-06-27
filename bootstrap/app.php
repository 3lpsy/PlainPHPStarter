<?php
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
$baseDirectory = realpath(__DIR__.'/../');
$logFile = $baseDirectory . "/" . getenv('LOG_DIRECTORY') . "/" . "log-" . date("Y-m-d");
$logger = new Logger('debug');
$logger->pushHandler(new StreamHandler($logFile, Logger::DEBUG));
$logger->addInfo("hello");

$app = new League\Container\Container;
$app->share('response', Zend\Diactoros\Response::class);
$app->share('request', function () {
    return Zend\Diactoros\ServerRequestFactory::fromGlobals(
        $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
    );
});

$app->share('emitter', Zend\Diactoros\Response\SapiEmitter::class);

$route = new League\Route\RouteCollection($app);

$route->map('GET', '/', function (ServerRequestInterface $request, ResponseInterface $response) {
    $response->getBody()->write('<h1>Hello, World!</h1>');

    return $response;
});

$response = $route->dispatch($app->get('request'), $app->get('response'));

$app->get('emitter')->emit($response);
