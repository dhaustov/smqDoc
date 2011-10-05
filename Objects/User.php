<?php

/**
 * Class for User Account
 *
 * @author Dmitry G. Haustov
 */
class UserAccount {
    var $Id;
    var $Login;
    var $Password;
    var $Status;    
    var $Name;
    var $Surname;
    var $MiddleName;
    var $LastAccess;
            
    function __construct($_login = null, $_password = null, 
                                $_status = null, $_name = null, $_surname = null, 
                                $_middlename = null, $_id = null ,$_lastaccess = null)
    {        
        $this->Id = $_id;
        $this->Login = $_login;
        $this->Password = $_password;
        $this->Status = $_status;
        $this->Name = $_name;
        $this->Surname = $_surname;
        $this->MiddleName = $_middlename;
        $this->LastAccess = $_lastaccess;
    }    

    //function __construct() {}
    
    
}

?>
