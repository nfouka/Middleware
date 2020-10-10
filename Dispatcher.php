<?php


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

    public function process(\Psr\Http\Message\ServerRequestInterface $request, \Psr\Http\Message\ResponseInterface $response)
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