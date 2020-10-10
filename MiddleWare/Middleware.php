<?php


namespace Middleware ;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class MiddleWare {
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next){
            $response = $response->withHeader('X-Foo', 'Bar');
            return $next($request , $response) ;
    }
}
