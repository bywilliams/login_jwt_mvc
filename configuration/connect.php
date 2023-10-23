<?php 
// use PDO;

define('host', 'localhost');
define('user', 'root');
define('dbname', 'login_jwt');
define('password', '');

class Connect 
{
    protected $connection;

    function __construct() 
    {
        $this->connecDatabase();
    }

    public function connecDatabase() 
    {
        try 
        {
            $this->connection = new PDO('mysql:host='.host.';dbname='.dbname, user, password, [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ // retorno da query em forma de objeto
            ]);
        } 
        catch (PDOException $e) 
        {
            echo "Error: ".$e->getMessage();
            die();
        }
    }

}


