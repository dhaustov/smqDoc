<?php

interface IValidator
{      
    public function IsValid($obj);    
    public function GetError();
}

?>
