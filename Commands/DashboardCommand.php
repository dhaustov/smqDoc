<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DashboardCommand
 *
 * @author Павел
 */

class DashboardCommand {
  /*разрешённые действия*/
    public $allowedActions = array(
        Actions::SAVE,
        Actions::SHOW
    );
    
    /* full REQUEST Command string */
    private $command;  
    
    /* Parsed command params*/
    public $action; 
    public $pageSize; 
    public $pageNum;
    public $id;
    
    public function __construct($_command)
    {
        $this->command = $_command;
        if(isset($this->command['action']))
        {
            foreach ($this->allowedActions as $action)
            {
                if($action == $this->command['action'])
                    $this->action = $action;
            }
        }
        
        if(!$this->action) 
            $this->action = Actions::SHOWLIST;
               
        if(isset($this->command['pagesize']))
                $this->pageSize = $this->command['pagesize'];
        
        if(isset($this->command['pagenum']))
                $this->pageNum = $this->command['pagenum'];
        
        if(isset($this->command['id']))
                $this->id = $this->command['id'];
    }
    
    public function IsValid()
    {
        if($this->action) return true;        
        return false;
    }
}
?>
