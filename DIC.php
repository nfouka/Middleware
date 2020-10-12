<?php


class DIC
{


    public $registry = [];

    /**
     * DIC constructor.
     */
    public function __construct()
    {
    }

    public function set(string $key, Closure $resolver)
    {
        $this->registry[$key] = $resolver;
    }

    public function get(string $string)
    {
        return $this->registry[$string]();
    }


}