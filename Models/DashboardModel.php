<?php

/**
 * Dashboard model
 *
 * @author Pavel
 */
class DashboardModel implements IModel
{      
    /* @var $currentCommand DashboardCommand */
    private $currentCommand; 
    private $error;
    
    public function __construct()
    {
    }
    public function PerformAction($_command)
    {        
        $this->currentCommand = $_command;
        switch($this->currentCommand->action)
        { 
        case Actions::SAVE :                         
            $currGroupId = $_POST['currGroupId'];
            LoginHelper::SetCurrentUserGroupId($currGroupId);
            break;
        }

        $ugRep = new UserGroupRepository();
        return $ugRep->GetListByMasterID(LoginHelper::GetCurrentUserId()); 

    }
    
    public function GetError()
    {
        return $this->error;
    }
}

?>
