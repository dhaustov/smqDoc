<?php
/**
 * Description of DocTemplateController
 *
 * @author Dmitry
 */
class DocTemplateController implements IController
{
    /* @var $model DocTemplateModel */
    var $model;
    /* @var $view DocTemplateView */
    var $view;
    /* @var $command DocTemplateCommand*/
    var $command;
    
    /* @var $result DocTemplate */
    var $result;  
    var $error;
            
    public function __construct($_command)
    {        
        $this->command = new DocTemplateCommand($_command);
        $this->model = new DocTemplateModel();
    }
    
    public function RunModel() 
    {                
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
        $this->view = new DocTemplateView($this->command);
        $this->view->SetResult($this->result, $this->error);
                
        /* Подгрузка в представление дополнительных данных */
        if( $this->command->action == Actions::CREATE || 
            $this->command->action == Actions::EDIT ||
            $this->command->action == Actions::SAVE ) 
        {            
            $this->view->lstFieldTypes = $this->model->GetFieldTypesList();       
        }
        
        if( $this->result &&
            $this->command->action == Actions::SHOWLIST )        
        {            
            $this->view->totalItems = $this->model->GetListItemsCount();
        }
            
        $mainLayoutTemplate = new MainLayoutView();
        $mainLayoutTemplate->title = "Система менеджмента качества";               
        $mainLayoutTemplate->header = new TemplateHeaderItem("Управление шаблонами документов");                
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
