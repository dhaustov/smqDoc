<?php


class Config {
    private static $instance;
    
    private $db_hostname="localhost";
    private $db_username='root';
    private $db_password='';
    private $db_name='smqdoc';
    private $smtp_username='gimn62@list.ru';
    private $smtp_port='2525';
    private $smtp_host='smtp.list.ru';
    private $smtp_password='CA464610';
    private $smtp_charset='UTF8';
    private $smtp_from='smqDoc server';
    private $email_admin='';
    private $email_developer='';
    private $errorlog_file='C:\appserv\smqDocLog.txt';
    private function __construct() 
    {
        //echo 'Я конструктор<br>';
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

//Db Getters
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

//SMTP Getters
public function SmtpUserName()
{
    return $this->smtp_username;
}
public function SmtpPort()
{
    return $this->smtp_port;
}
public function SmtpHost()
{
    return $this->smtp_host;
}
public function SmtpPassword()
{
    return $this->smtp_password;
}
public function SmtpCharset()
{
    return $this->smtp_charset;
}
public function SmtpFrom()
{
    return $this->smtp_from;
}
public function EmailAdmin()
{
    return $this->email_admin;
}
public function EmailDeveloper()
{
    return $this->email_developer;
}

public function ErrorLogFile()
{
    return $this->errorlog_file;
}
public function ErrorLogLevel()
{
    return $this->errorlog_level;
}
}
?>
