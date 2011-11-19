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
        $ugRep = new UserGroupRepository();
        $cugId = LoginHelper::GetCurrentUserGroupId();
        if($cugId)
            return $ugRep->GetListByMasterID($cugId); 
        else
            return false;
    }
    
    public function GetError()
    {
        return $this->error;
    }
}

?>
