<?php


namespace Middleware ;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class TraininSlashMiddleWare {
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next){
        $url = (string) $request->getUri()->getPath() ;
        if(!empty($url) &&  str_ends_with($url,"/") ){
            return $response
                ->withHeader('Location' , substr($url,0,-1))
                ->withStatus(301) ;
        }else{
            return $next($request , $response) ;
        }
    }
}