<?php

/**
 * Description of testController
 *
 * @author pserdukov
 */

class DashboardController implements IController
{
    /* @var $model DashboardModel */
    var $model;
    /* @var $view DashboardView */
    var $view;
    /* @var $command DashboradCommand*/
    var $command;
    var $result;  
    var $error;
    
    
    
    public function __construct($_command)
    {        
        $this->command = new DashboardCommand($_command);
        $this->model = new DashboardModel();
    }
    
    public function RunModel() 
    {
            $res = $this->model->PerformAction($this->command);
            
            if($res)
            {                                    
                $this->result = $res;
            }
            else
            {
                $this->result = false;
                $this->error = $this->model->GetError();
                return false;
            }
        
        return true;
    }
    
    public function ShowResult()
    {              
        $this->view = new DashboardView();
        $this->view->SetResult($this->result, $this->error);
        
        
        $mainLayoutTemplate = new MainLayoutView();
        $mainLayoutTemplate->title = "Система менеджмента качества";               
        $mainLayoutTemplate->header = new TemplateHeaderItem("Домашняя пользователя");                
        $mainLayoutTemplate->footer = new TemplateFooterItem( __CLASS__ );                                
        $mainLayoutTemplate->menu = $this->view->GetMenuItems();
        
        $mainLayoutTemplate->ShowPage($this->view);
    }
    
    public function GetError()
    {
        return $this->error;
    }
}

?>
