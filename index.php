<?php


require 'DIC.php';

class Connection {

    private $db_name;
    private $db_user;
    private $db_pass;

    /**
     * Connection constructor.
     * @param $db_name
     * @param $db_user
     * @param $db_pass
     */
    public function __construct($db_name, $db_user, $db_pass)
    {
        $this->db_name = $db_name;
        $this->db_user = $db_user;
        $this->db_pass = $db_pass;
    }


}

class Model {

    private $connection;

    /**
     * Model constructor.
     * @param $connection
     */
    public function __construct(Connection  $connection)
    {
        $this->connection = $connection;
    }


}

$connection = new Connection('root','root','root') ;
$model      = new Model($connection) ;


$dic = new DIC() ;
$dic->set('connection',function(){
    return new Connection('root','root','root') ;
});

$dic->set('model',function() use ($dic) {
    return new Model($dic->get('connection'));
});


var_dump($dic->get(('model')));