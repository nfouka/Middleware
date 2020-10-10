<?php

require './vendor/autoload.php' ;
require 'Dispatcher.php';

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\ServerRequest;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use function Http\Response\send;


$request = ServerRequest::fromGlobals();
$response= new Response() ;


$trainingSlashMiddleWare = function(ServerRequestInterface $request, ResponseInterface $response , callable $next){
    $response->getBody()->write('*');
    $response =  $next($request,$response) ;
    $response->getBody()->write('*');
    return $response ;
};

$trainingSlashMiddleWare2 = function(ServerRequestInterface $request, ResponseInterface $response , callable $next){
    $response->getBody()->write('^');
    $response =  $next($request,$response) ;
    $response->getBody()->write('^');
    return $response ;
};




$dispatcher = new Dispatcher();
$dispatcher->pipe( new \Middleware\TraininSlashMiddleWare() ) ;
$dispatcher->pipe( new \Psr7Middlewares\Middleware\Uuid()) ;
$dispatcher->pipe( new \Psr7Middlewares\Middleware\FormatNegotiator() ) ;
$dispatcher->pipe( new \Middleware\MiddleWare() ) ;
$dispatcher->pipe( $trainingSlashMiddleWare2 ) ;
$dispatcher->pipe( new \Middleware\App() ) ;



send($dispatcher->process($request,$response));
















