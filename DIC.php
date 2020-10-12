<?php


class DIC{

    private $registry = [];
    private $factories = [];
    private $instances= [];

    /**
     * Ajoute un élément dans le conteneur
     * @param $key
     * @param callable $resolver
     */
    public function set($key, Callable $resolver){
        $this->registry[$key] = $resolver;
    }

    /**
     * Ajoute un élément qui sera instancié à chaque appel
     * @param $key
     * @param callable $resolver
     */
    public function setFactory($key, Callable $resolver){
        $this->factories[$key] = $resolver;
    }

    /**
     * Ajoute une instance à notre conteneur, la clef sera le nom de la class
     * @param $instance
     */
    public function setInstance($instance){
        $reflection = new \ReflectionClass($instance);
        $this->instances[$reflection->getName()] = $instance;
    }

    /**
     * Récupère une instance à partir de la clef
     * @param $key
     * @return mixed
     * @throws Exception
     */
    public function get($key){
        if(isset($this->factories[$key])){
            return $this->factories[$key]();
        }
        if(!isset($this->instances[$key])){
            if(isset($this->registry[$key])){
                $this->instances[$key] = $this->registry[$key]($this);
            } else {
                $this->instances[$key] = $this->resolve($key);
            }
        }
        return $this->instances[$key];
    }

    /**
     * Instancie la classe à partir de son nom
     * @param $key
     * @return object
     * @throws Exception
     */
    private function resolve($key){
        $reflected_class = new \ReflectionClass($key);
        if($reflected_class->isInstantiable()){
            $constructor = $reflected_class->getConstructor();
            if($constructor){
                $parameters = $constructor->getParameters();
                $constructor_parameters = [];
                foreach($parameters as $parameter){
                    if( $parameter->getClass() ){
                        $constructor_parameters[] = $this->get($parameter->getClass()->getName());
                    } else {
                        $constructor_parameters[] = $parameter->getDefaultValue();
                    }
                }
                return $reflected_class->newInstanceArgs($constructor_parameters);
            } else {
                return $reflected_class->newInstance();
            }
        } else {
            throw new Exception($key . " is not an instanciable Class");
        }
    }

}