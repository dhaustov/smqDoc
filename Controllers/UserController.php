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
            
    public function __construct($_command)
    {        
        $this->command = new UserCommand($_command);
    }
    
    public function RunModel() 
    {
        $this->model = new UserModel();
        
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
        $this->view = new UserView($this->command);
        $this->view->ShowPage($this->result, $this->error);
    }
    
    public function GetError()
    {
        return $this->error;
    }
}

?>
