<?php


namespace Middleware ;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class App {
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next){
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
    }
}
