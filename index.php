<?php


require 'DIC.php';



class Foo {

}

class Zoo {

}

Class Bar {


    private $foo ;
    private $zoo ;

    /**
     * Bar constructor.
     * @param $foo
     */
    public function __construct(Foo $foo,$tab=[] , Zoo $zoo )
    {
        $this->foo = $foo;
        $this->foo = $zoo;
    }

        public function sayHello(){
                return  "hello";
        }


}



$app = new DIC();

$app->set('Foo', function($app){
    return new Foo();
});


var_dump($app->get('Foo'));


