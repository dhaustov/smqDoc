<?php

interface IObjectRepository
{
    public function Save($obj);    
    public function Delete($obj);        
    public function GetByID($id);        
    public function CheckForExists($obj);
    
}

?>
