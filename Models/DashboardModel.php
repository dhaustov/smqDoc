<?php

/**
 * Dashboard model
 *
 * @author Pavel
 */
class DashboardModel implements IModel
{      
    private $error;
    
    public function __construct()
    {
    }
    public function PerformAction($_command)
    {        
        return true; 
    }
    
    public function GetError()
    {
        return $this->error;
    }
}

?>
