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


$app =  function(ServerRequestInterface $request, ResponseInterface $response , callable $next) {

    $url = $request->getUri()->getPath() ;
    if($url === '/blog') {
        $response->getBody()->write('Je suis sur le blog');
    }elseif ( $url === '/contact'){
        $response->getBody()->write('Je suis sur le contact');
    }else{
        $response->getBody()->write('Not Found');
        $response->withStatus(400) ;
    }
    return $response ;

};


$dispatcher = new Dispatcher();
$dispatcher->pipe( new \Middleware\TraininSlashMiddleWare() ) ;
$dispatcher->pipe( new \Psr7Middlewares\Middleware\Uuid()) ;
$dispatcher->pipe( new \Psr7Middlewares\Middleware\FormatNegotiator() ) ;
$dispatcher->pipe( $trainingSlashMiddleWare ) ;
$dispatcher->pipe( $trainingSlashMiddleWare2 ) ;
$dispatcher->pipe( $app ) ;



send($dispatcher->process($request,$response));
















