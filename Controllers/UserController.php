<?php

/**
 * Description of testController
 *
 * @author Dmitry
 */

class UserController implements IController
{
    /* @var $model UserModel */
    var $model;
    /* @var $view UserView */
    var $view;
    /* @var $command UserCommand*/
    var $command;
    
    var $result;  
    var $error;
    
    /* full REQUEST Command string */
    //var $command;  
    
    /* Parsed command params*/
    //var $action; 
    //var $pageSize; 
    //var $pageNum;
    //var $id;
    
    public function __construct($_command)
    {        
        $this->command = new UserCommand($_command);
    }
    
    public function RunModel() 
    {
        $this->model = new UserModel();
        
        //if($this->ParseCommand()) //дана корректная команда
        if($this->command->IsValid())
        {            
            $res = $this->model->PerformAction($this->command);
            
            if($res)
                $this->result = $res;
            else
            {
                $this->result = false;
                $this->error = $this->model->GetError();
                return false;
            }
        }
        else 
        {
            $this->result = false;
            $this->error = "Введена неверная команда";
            return false;
        }
        
        return true;
    }
    
    public function ShowResult()
    {      
        /*
        $this->view = new UserView( $this->action, 
                                    $this->id, 
                                    $this->pageSize, 
                                    $this->pageNum);
        */
        //FIXIT        
        $this->view = new UserView( $this->command->action, 
                                    $this->command->id, 
                                    $this->command->pageSize, 
                                    $this->command->pageNum);
        
        $this->view->ShowPage($this->result, $this->error);
    }
    
    /*
    public function ParseCommand()
    {
        foreach ($this->model->GetAllowedActions() as $action)
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
        return true;
    }
    */
    
    public function GetError()
    {
        return $this->error;
    }
}

?>
