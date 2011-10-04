<?php

interface IObjectRepository
{
    function Save($obj) 
    { }
    
    function Delete($obj)
    { }
    
    function GetByID($id) 
    { }
    
    function CheckForExists($obj)
    { }    
}

?>
