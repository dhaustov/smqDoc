<?php

/**
 * Class for User Account
 *
 * @author Dmitry G. Haustov
 */
class UserAccount {
    public $Id;
    public $Login;
    public $Password;
    public $Status;    
    public $Name;
    public $Surname;
    public $MiddleName;
    public $LastAccess;
            
    public function __construct($_id, $_login, $_password, 
                                $_status, $_name, $_surname, 
                                $_middlename, $_lastaccess = null)
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
}

?>
