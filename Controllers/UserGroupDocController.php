<?php

/**
 * Description of UserGroupDocController
 *
 * @author Dmitry
 */
class UserGroupDocController implements IController
{
      /* @var $model UserGroupDocModel */
    var $model;
    /* @var $view UserGroupDocView */
    var $view;
    /* @var $command UserGroupDocCommand*/
    var $command;
    
    var $result;  
    var $error;
    
        
    public function __construct($_command)
    {        
        $this->command = new UserGroupDocCommand($_command);
    }
    
    public function RunModel() 
    {
        $this->model = new UserGroupDocModel();
        
        if($this->command->IsValid())
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
        $this->view = new UserGroupDocView($this->command);
        $this->view->SetResult($this->result, $this->error);
        
        if($this->command->action == Actions::SHOWLIST)
        {
            $this->view->totalItems = $this->model->GetListItemsCount();
        }
        
        if($this->command->action == Actions::CREATE || 
           $this->command->action == Actions::SAVE
          )
        {
            $ug = LoginHelper::GetCurrentUserGroup();
            $urg = new UserGroupRepository();            
            $this->view->allowedTemplates = $urg->GetUserGroupDocTemplatesFromParentGroup($ug);            
        }
        
        $mainLayoutTemplate = new MainLayoutView();
        $mainLayoutTemplate->title = "Система менеджмента качества";               
        $mainLayoutTemplate->header = new TemplateHeaderItem("Создание документов");                
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
