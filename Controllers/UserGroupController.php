<?php

/**
 * Description of UserGroupController
 *
 * @author Dmitry
 */
class UserGroupController implements IController
{
      /* @var $model UserGroupModel */
    var $model;
    /* @var $view UserView */
    var $view;
    /* @var $command UserGroupCommand*/
    var $command;
    
    /* @var $result UserGroup */
    var $result;  
    var $error;
            
    public function __construct($_command)
    {        
        $this->command = new UserGroupCommand($_command);
        $this->model = new UserGroupModel();
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
        $this->view = new UserGroupView($this->command);
        $this->view->SetResult($this->result, $this->error);
                
        /* Подгрузка в представление дополнительных данных */
        if( $this->command->action == Actions::CREATE || 
            $this->command->action == Actions::EDIT ||
            $this->command->action == Actions::SAVE ) 
        {            
            $this->view->userAccounts = $this->model->GetUserList();
            $this->view->otherGroups = $this->model->GetOtherGroupsList();
           
            $this->view->lstDocTemplatesExists = $this->model->GetDocTemplatesExistsList();
            $this->view->lstDocTemplatesAll = $this->model->GetDocTemplatesAllList();
        }
        
        if( $this->result &&
            $this->command->action == Actions::SHOW )
        {
            $this->view->lstDocTemplatesExists = $this->model->GetDocTemplatesExistsList();
            
            if($this->result->idMasterUserAccount > 0)
                $this->view->masterUser = $this->model->GetMasterUser($this->result->idMasterUserAccount);
            
            if($this->result->idParentGroup > 0)
               $this->view->parentGroup = $this->model->GetParentGroup($this->result->idParentGroup);
            else
                $this->view->parentGroup = new UserGroup( null, "---" );
        }
        
        if( $this->result &&
            $this->command->action == Actions::SHOWLIST )        
        {
            $masterUsers = Array();
            $parentGroups = Array();
            
            $urep = new UserRepository(); //сам знаю, что плохо!
            $grep = new UserGroupRepository();
            
            $i=0;
            foreach($this->result as $gr)
            {
                //TODO: добавить обработку ошибок для удалённых юзеров и групп
                if($gr->idMasterUserAccount > 0)
                    $masterUsers[$i] = $urep->GetById($gr->idMasterUserAccount);
                else 
                {
                    $masterUsers[$i] = new UserAccount();
                    $masterUsers[$i]->name = "-";
                    $masterUsers[$i]->surName = "-";
                    $masterUsers[$i]->middleName = "-";
                }
                
                if($gr->idParentGroup > 0)
                    $parentGroups[$i] = $grep->GetById($gr->idParentGroup);
                else
                {
                    $parentGroups[$i] = new UserGroup();      
                    $parentGroups[$i]->name= "-";                    
                }
                
                $i++;
            }                      
            $this->view->lstGroupMasterUsers = $masterUsers;
            $this->view->lstGroupParents = $parentGroups;
            $this->view->totalItems = $this->model->GetListItemsCount();
        }
            
        $mainLayoutTemplate = new MainLayoutView();
        $mainLayoutTemplate->title = "Система менеджмента качества";               
        $mainLayoutTemplate->header = new TemplateHeaderItem("Управление группами и ролями пользователей");                
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
