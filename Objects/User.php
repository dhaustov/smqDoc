<?php

/**
 * Class for User Account
 *
 * @author Dmitry G. Haustov
 */
class UserAccount {
    public $id;
    public $login;
    public $password;
    public $status;    
    public $name;
    public $surName;
    public $middleName;
    public $lastAccess;
            
    function __construct($_login = null, $_password = null, 
                                $_name = null, $_surName = null, 
                                $_middleName = null, $_status = null, $_id = null ,$_lastAccess = null)
    {        
        $this->id = $_id;
        $this->login = $_login;
        $this->password = $_password;        
        $this->name = $_name;
        $this->surName = $_surName;
        $this->middleName = $_middleName;
        $this->lastAccess = $_lastAccess;
        
         if($_status === null)
            $this->status = DbRecordStatus::ACTIVE;
        else
            $this->status = $_status;
    }    

    //function __construct() {}        
}

?>
