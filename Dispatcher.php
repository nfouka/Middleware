<?php


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Dispatcher
{

    private $middlewares = [];
    public $index = 0;

    /**
     * Dispatcher constructor.
     */
    public function __construct()
    {
    }

    public function pipe(callable $trainingSlash)
    {
        $this->middlewares[] = $trainingSlash ;
    }

    public function process(ServerRequestInterface $request, ResponseInterface $response) : ResponseInterface
    {
        $middleware = $this->getMiddleware();
        $this->index++;

        if(is_null($middleware)){
            return $response ;
        }else{
            return $middleware($request,$response, [$this,'process']) ;
        }
    }


    private function getMiddleware(){
        if( isset($this->middlewares[$this->index])) {
            return $this->middlewares[$this->index] ;
        }else{
            return null ;
        }
    }
}