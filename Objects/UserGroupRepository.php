<?php

/**
 * Description of UserGroupRepository
 *
 * @author Dmitry
 */
class UserGroupRepository {
    /*
     * IObjectRepository Methods
     */    
    public function Save($obj)  
    { 
        /* @var $usrGroup UserGroup */
        $usrGroup = $obj;
        
        if( $usrGroup->id > 0 ) //Updating Existing UserGroup
        {
                $query = "update user_groups set                                                             
                              name = '".ToolsHelper::CleanInputString($usrGroup->name)."',                             
                              idParentGroup = '".ToolsHelper::CleanInputString($usrGroup->idParentGroup)."', 
                              idMasterUserAccount = '".ToolsHelper::CleanInputString($usrGroup->idMasterUserAccount)."', 
                              masterUserAccountRole = '".ToolsHelper::CleanInputString($usrGroup->masterUserAccountRole)."',
                              status = '".ToolsHelper::CleanInputString($usrGroup->status)."'
                          where id =". intval($usrGroup->id);
                
                $numRows = SqlHelper::ExecUpdateQuery($query);
                                
                if(!$numRows)
                {
                    $this->error = "При обновлении группы пользователей произошла ошибка!";
                    NotificationHelper::LogCritical("Error in class: '".__CLASS__."' method: '".__METHOD__."' query: '$query'");
                    return false;
                }
                return $usrGroup->id;
        }
        else //Trying to save new user group
        {
            if($this->CheckForExists($usrGroup))
            {
                $this->error = "Такая группа уже существует";
                return false;
            }

            $query = "insert into user_groups (name, idParentGroup, idMasterUserAccount, masterUserAccountRole, status) 
                                  values ( '".ToolsHelper::CleanInputString($usrGroup->name)."',
                                           '".ToolsHelper::CleanInputString($usrGroup->idParentGroup)."',
                                           '".ToolsHelper::CleanInputString($usrGroup->idMasterUserAccount)."',
                                           '".ToolsHelper::CleanInputString($usrGroup->masterUserAccountRole)."',
                                           '".ToolsHelper::CleanInputString($usrGroup->status)."'      
                                          )";

            $newid = SqlHelper::ExecInsertQuery($query);

            if(!$newid)
            {
                $this->error = "При сохранении пользовательской группы возникла ошибка!";
                NotificationHelper::LogCritical("Error in class: '".__CLASS__."' method: '".__METHOD__."' query: '$query'");
                return false;
            }
            return $newid;
        }                
    }
    
    public function Delete($obj)
    { 
        /* @var $usrGroup UserGroup */
        $usrGroup = $obj;
        $query = "update user_groups set status = ".UserStatus::DELETED." where id =". intval($usrGroup->id);
        $rowNum = SqlHelper::ExecDeleteQuery($query);
                
        if (!$rowNum)
        {
            $this->error = "При удалении группы возникла ошибка!";
            NotificationHelper::LogCritical("Error in class: '".__CLASS__."' method: '".__METHOD__."' query: '$query'");
            return false;
        }
        return $rowNum;
    }
   
    public function GetById($id) 
    { 
        /* @var $usrGroup UserGroup */
        $usrGroup = new UserGroup();
        
        $query = "select id,name,idParentGroup,idMasterUserAccount,masterUserAccountRole,status from user_groups where id = ". intval($id);
        $obj = SqlHelper::ExecSelectRowQuery($query);
        
        if ($obj)
        {
            /* @var $user UserAccount */
            $usrGroup->id = $obj['id'];
            $usrGroup->idMasterUserAccount = $obj['idMasterUserAccount'];
            $usrGroup->idParentGroup = $obj['idParentGroup'];
            $usrGroup->status = $obj['status'];
            $usrGroup->name = $obj['name'];
            $usrGroup->masterUserAccountRole = $obj['masterUserAccountRole'];
                       
            return $usrGroup;
        }
        else 
            return false;
        
    }
    
    public function CheckForExists($obj)
    { 
        /* @var $usrGroup UserGroup */
        $usrGroup = $obj;
        
        $query = "select id from user_groups where name='".ToolsHelper::CleanInputString($usrGroup->name)."' 
                                               AND idMasterUserAccount = '".ToolsHelper::CleanInputString($usrGroup->idMasterUserAccount)."'";
        $obj = SqlHelper::ExecSelectValueQuery($query);
        
        if ($obj)
            return true;
        else 
            return false;        
    }  
    
    /*
     * Additional Methods
     */      
    public function GetListByMasterID($masterUserAccountId, $status = null)
    {
        $retArr = false;
        $query = "select id,name,idParentGroup,idMasterUserAccount,masterUserAccountRole,status
                  from user_groups where idMasterUserAccount = ".intval($masterUserAccountId);
        if($status)
            $query.=" and status = $status";
        $res = SqlHelper::ExecSelectCollectionQuery($query);
        $i=0;
        foreach($res as $row)
        {
            $usrGroup = new UserGroup(                        
                        $row['idMasterUserAccount'],
                        $row['name'],
                        $row['masterUserAccountRole'],
                        $row['idParentGroup'],
                        $row['status']                        
                    );
            $retArr[$i] = $usrGroup;
            $i++;
        }
        if($retArr)
            return $retArr;
        else
        {
            $this->error = "Групп пользователей не найдено";
            return false;
        }        
    }
    
    /*
     * Document templates collection functions 
     */
    public function LoadDocTemplatesCollection($obj)
    {
        /* @var $usrGroup UserGroup */
        $usrGroup = $obj;
        //TODO: add logic here...
        return $usrGroup;
    }
    
    public function AddNewDocTemplateToCollection($obj, $templateID)
    {
        //TODO: addlogic here...        
        return false;
    }        
    
    public function DeleteDocTemplateFromCollection($obj, $templateID)
    {
        //TODO: add logic here..
        
        return false;
    }
    
    public function GetError()
    {
        return $this->error;
    }
}

?>
