<?php
/**
 * Description of CommandUser
 *
 * @author Dmitry
 */
class UserCommand
{
    /*разрешённые действия*/
    var $allowedActions = array(
        Actions::CREATE,
        Actions::EDIT,
        Actions::DELETE,
        Actions::SAVE,
        Actions::SHOW,
        Actions::SHOWLIST
    );
    
    /* full REQUEST Command string */
    var $command;  
    
    /* Parsed command params*/
    var $action; 
    var $pageSize; 
    var $pageNum;
    var $id;
    
    public function __construct($_command)
    {
        $this->command = $_command;
        
        foreach ($this->allowedActions as $action)
        {
            if($action == $this->command['action'])
                $this->action = $action;
        }
        
        if(!$this->action) //default action ??
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
