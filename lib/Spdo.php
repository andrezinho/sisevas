<?php
class Spdo extends PDO 
{
    private static $instance = null;
        
    protected $host = 'localhost';
    protected $port = '5432';
    protected $dbname= 'sisevas_';
    protected $user= 'postgres';
    protected $password= 'torres04';
    /*
    protected $host = '192.168.1.5';
    protected $port = '5432';
    protected $dbname= 'sisevas';
    protected $user= 'postgres';
    protected $password= 'corpomedic123';
    */
    public function __construct()
    {
        $dns='pgsql:dbname='.$this->dbname.';host='.$this->host.';port='.$this->port;
        $user = $this->user;
        $pass = $this->password;
        parent::__construct($dns,$user,$pass);
    }
    
    public static function singleton()
    {
        if( self::$instance == null )
        {
            self::$instance = new self();
        }
        return self::$instance;
    }
}
?>