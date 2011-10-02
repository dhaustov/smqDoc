<?php


class Config {
    private $db_hostname="localhost";
    private $db_username='smqdoc';
    private $db_password='sqmdoc';
    private $db_name='smqdoc';
    
    private static $instance;
    private function __construct() 
    {
        echo 'Я конструктор<br>';
    }
    /**
 * @return Config
 */
public static function singleton() 
    {
        if (!isset(self::$instance)) {
            $c = __CLASS__;
            self::$instance = new $c;
        }

        return self::$instance;
    }

public function DbHostName()
{
    return $this->db_hostname;
}
public function DbUserName()
{
    return $this->db_username;
}
public function DbPassword()
{
    return $this->db_password;
}
public function DbName()
{
    return $this->db_name;
}
}
?>
