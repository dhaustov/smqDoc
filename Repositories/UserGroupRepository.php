<?php

/**
 * Description of UserGroupRepository
 *
 * @author Dmitry
 */
class UserGroupRepository implements IObjectRepository
{
    /*
     * IObjectRepository Methods
     */    
    public function Save($obj)  
    { 
        /* @var $usrGroup UserGroup */
        $usrGroup = $obj;
        
        if( $usrGroup->id > 0 ) //Updating Existing UserGroup
        {
                $tr = SqlHelper::StartTransaction();
                $query = "update user_groups set                                                             
                              name = '".ToolsHelper::CleanInputString($usrGroup->name)."',                             
                              idParentGroup = '".ToolsHelper::CleanInputString($usrGroup->idParentGroup)."', 
                              idMasterUserAccount = '".ToolsHelper::CleanInputString($usrGroup->idMasterUserAccount)."', 
                              masterUserAccountRole = '".ToolsHelper::CleanInputString($usrGroup->masterUserAccountRole)."',
                              status = '".ToolsHelper::CleanInputString($usrGroup->status)."'
                          where id =". intval($usrGroup->id);
                
                $numRows = SqlHelper::ExecUpdateQuery($query);
                                
                //обновлем темплейты
                $rep = new DocTemplateRepository();
                $lst = $rep->GetListByGroupID($usrGroup->id);
                $lstNewTemplates = $usrGroup->GetRelatedDocTemplates();
//                if($lst)
//                {
//                    foreach ($lst as $t)
//                    {
//                        if(!$lstNewTemplates || !in_array($t->id,$lstNewTemplates ))
//                        {
//                            $delQuery = "delete from usergroups_doctemplates where idGroup = '".$usrGroup->id."' and idDoctemplate = '".$t->id."'";
//                            $res = SqlHelper::ExecDeleteQuery($delQuery);
//                        }
//                    }                                        
//                }
                
                if($lstNewTemplates)
                {
                    foreach ($lstNewTemplates as $t)
                    {
                        if(!$lst || !in_array($t ,$lst))
                        {
                            $insQuery = "insert into usergroups_doctemplates (idGroup,idDoctemplate) values ('".$usrGroup->id."','$t') ";
                            $res = SqlHelper::ExecInsertQuery($insQuery);
                        }
                    }
                }
                
                if(!$numRows)
                {
                    SqlHelper::RollbackTransaction($tr);
                    $this->error = "При обновлении группы пользователей произошла ошибка!";
                    NotificationHelper::LogCritical("Error in class: '".__CLASS__."' method: '".__METHOD__."' query: '$query'");
                    return false;
                }
                else
                {
                    SqlHelper::CommitTransaction($tr);                    
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

            /*
            //добавляем темплейты
            $lstNewTemplates = $usrGroup->GetRelatedDocTemplates();
            foreach ($lstNewTemplates as $t)
            {                        
                $insQuery = "insert into usergroups_doctemplates (idGroup,idDoctemplate) values ('".$usrGroup->id."','$t') ";
                $res = SqlHelper::ExecInsertQuery($insQuery);                     
            }
              */
            
            if(!$newid)
            {
                $this->error = "При сохранении пользовательской группы возникла ошибка!";
                NotificationHelper::LogCritical("Error in class: '".__CLASS__."' method: '".__METHOD__."' query: '$query'");
                return false;
            }
            $obj->id = $newid;
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
        // $usrGroup = new UserGroup();
        
        $query = "select id,name,idParentGroup,idMasterUserAccount,masterUserAccountRole,status from user_groups where id = ". intval($id);
        $obj = SqlHelper::ExecSelectRowQuery($query);
        
        if ($obj)
        {
            $usrGroup = new UserGroup($obj['idMasterUserAccount']);
            
            $usrGroup->id = $obj['id'];            
            $usrGroup->idParentGroup = $obj['idParentGroup'];
            $usrGroup->status = $obj['status'];
            $usrGroup->name = $obj['name'];
            $usrGroup->masterUserAccountRole = $obj['masterUserAccountRole'];
                       
            return $usrGroup;
        }
        else 
        {
            $this->error = "Группа не найдена";
            return false;
        }
        
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
    
    public function GetList($pageSize = 1, $pageNum = 1, $status = null)
    {
        $retArr = false;
        $query = "select id,name,idParentGroup,idMasterUserAccount,masterUserAccountRole,status
                  from user_groups ";
                                
        if($status)
            $query.="  where status = $status";        
        
        if($pageSize > 1)        
            $query.=" limit ".((int)$pageNum * (int)$pageSize).",".$pageSize;        
        
        $res = SqlHelper::ExecSelectCollectionQuery($query);
        $i=0;
        if($res)
        {
            foreach($res as $row)
            {
                $usrGroup = new UserGroup(                        
                            $row['idMasterUserAccount'],
                            $row['name'],
                            $row['masterUserAccountRole'],
                            $row['idParentGroup'],
                            $row['status'],
                            $row['id']
                        );
                $retArr[$i] = $usrGroup;
                $i++;
            }
        }
        if($retArr)
            return $retArr;
        else
        {
            $this->error = "Групп пользователей не найдено";
            return false;
        }        
    }
    
    public function GetListItemsCount($status = null)
    {
        $query = "select count(*)
                  from user_groups ";
        if($status)
            $query.="  where status = $status";        
        $res = SqlHelper::ExecSelectValueQuery($query);
        
        if($res)
            return $res;
        else return 0;
    }
    
    public function GetListByMasterID($masterUserAccountId, $status = null)
    {
        $retArr = false;
        $query = "select id,name,idParentGroup,idMasterUserAccount,masterUserAccountRole,status
                  from user_groups where idMasterUserAccount = ".intval($masterUserAccountId);
        if($status)
            $query.=" and status = $status";
        $res = SqlHelper::ExecSelectCollectionQuery($query);
        $i=0;
        if($res)
        {
            foreach($res as $row)
            {
                $usrGroup = new UserGroup(                        
                            $row['idMasterUserAccount'],
                            $row['name'],
                            $row['masterUserAccountRole'],
                            $row['idParentGroup'],
                            $row['status'],
                            $row['id']
                        );
                $retArr[$i] = $usrGroup;
                $i++;
            }
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
     * UserGroupDocTemplates
     * Document templates collection functions 
     */
    public function SaveUserGroupDocTemplate($obj)
    {
        /* @var $usrGroupDocTemplate UserGroupDocTemplates */
        $usrGroupDocTemplate = $obj;
        if( $usrGroupDocTemplate->id > 0 )
        {
            $query = "update groups_docs set 
                            idUserGroups = ".intval($usrGroupDocTemplate->idUserGroups).",
                            idDocTemplate = ".intval($usrGroupDocTemplate->idDocTemplate).",
                            name = ".ToolsHelper::CleanInputString($usrGroupDocTemplate->name).",
                            startDate = ".ToolsHelper::CleanInputString($usrGroupDocTemplate->startDate).",
                            endDate  = ".ToolsHelper::CleanInputString($usrGroupDocTemplate->endDate)." ,
                            status = ".intval($userGroupDocTemplate->status)."
                      where id = ".intval($usr);
            //==DbRecordStatus::DELETED ? DbRecordStatus::DELETED : DbRecordStatus::ACTIVE.
             $numRows = SqlHelper::ExecUpdateQuery($query);
                                
                if(!$numRows)
                {
                    $this->error = "При обновлении шаблонов документов для группы пользователей произошла ошибка!";
                    NotificationHelper::LogCritical("Error in class: '".__CLASS__."' method: '".__METHOD__."' query: '$query'");                    
                }
                return $usrGroupDocTemplate->id;
        }
        else
        {
            $query = "insert into groups_docs (idUserGroups,idDocTemplate,name,startDate,endDate,status)
                      values (
                                ".intval($usrGroupDocTemplate->idUserGroups).",
                                ".intval($usrGroupDocTemplate->idDocTemplate).",
                                '".ToolsHelper::CleanInputString($usrGroupDocTemplate->name)."',
                                '".ToolsHelper::CleanInputString($usrGroupDocTemplate->startDate)."',
                                '".ToolsHelper::CleanInputString($usrGroupDocTemplate->endDate)."',
                                ".intval($usrGroupDocTemplate->status)."
                             )";
            $newid = SqlHelper::ExecInsertQuery($query);

            if(!$newid)
            {
                $this->error = "При сохранении шаблона документа для пользовательской группы возникла ошибка!";
                NotificationHelper::LogCritical("Error in class: '".__CLASS__."' method: '".__METHOD__."' query: '$query'");                
            }
            return $newid;
        }
        
        return false;
    }
    
    public function LoadDocTemplatesCollection($obj)
    {
        /* @var $usrGroup UserGroup */
        $usrGroup = $obj;
        $docTemplatesCollection = false;
        
        $query = "select id, name, idUserGroups, idDocTemplate, startDate, endDate, status
                  from groups_docs where idUserGroups = ".intval($usrGroup->id)."
                  and status = ".DbRecordStatus::ACTIVE;
        
        $res = SqlHelper::ExecSelectCollectionQuery($query);
        $i=0;      
        //echo "count res - ".count($res)."<br />";
        if($res)
        {
            foreach($res as $row)
            {
                /* @var $item UserDocTemplates */
                $item = new UserGroupDocTemplates(
                            $row["idUserGroups"],
                            $row["idDocTemplate"],
                            $row["name"],
                            $row["startDate"],
                            $row["endDate"],
                            $row["status"],
                            $row["id"]
                        );
                $docTemplatesCollection[$i] = $item;
                $i++;
            }
        }
        $usrGroup->AddRelatedDocTemplates($docTemplatesCollection);        
        return $usrGroup;
    }
    
    public function AddNewDocTemplateToCollection($obj, $templateID, $name=null, $startDate = null, $endDate = null)
    {
        /* @var $usrGroups UserGroup */
        $usrGroups = $obj;   
        /* @var $usrGroupsDocTemplate UserGroupDocTemplates */
        $usrGroupsDocTemplate = new UserGroupDocTemplates(
                    $usrGroups->id,
                    $templateID,
                    $name,
                    $startDate,
                    $endDate
                );
        $newID = $this->SaveUserGroupDocTemplate($usrGroupsDocTemplate);
        //echo "newID: $newID <br />";
        if($newID > 0)
        {
            $usrGroups = $this->LoadDocTemplatesCollection($usrGroups);
            return $usrGroups;
            //return true;
        }        
        return false;
    }        
    
    public function DeleteDocTemplateFromCollection($obj, $templateID)
    {
        /* @var $usrGroups UserGroup */
        $usrGroups = $obj;   
        
        $query = "update groups_users set status = ".DbRecordStatus::DELETED."
                    where idDocTemplate = ".intval($templateID)." 
                      and idUserGroups = ".intval($obj->id)." ";
        
        $numRows = SqlHelper::ExecUpdateQuery($query);
                                
        if(!$numRows)
        {
            $this->error = "При обновлении удалении шаблона документов для группы пользователей произошла ошибка!";
            NotificationHelper::LogCritical("Error in class: '".__CLASS__."' method: '".__METHOD__."' query: '$query'");                    
        }
        else
            {
                $usrGroups = $this->LoadDocTemplatesCollection($usrGroups);
                return $usrGroups;
            }

        return false;
    }
    
    
    /*Parents and hildren methods*/
    public function GetParentUserGroup($obj)
    {
        /* @var $usrGrp UserGroup */
        $usrGrp = $obj;
        if($usrGrp->idParentGroup >0 )
            return $this->GetById($usrGrp->idParentGroup);
        
        return false;
    }
    
    public function GetChildList($obj)
    {
       /* @var $usrGrp UserGroup */
        $usrGrp = $obj;
        
        $query = "select id from user_groups where idParentGroup =".intval($usrGrp->id);
        $res = SqlHelper::ExecSelectCollectionQuery($query);
        $resArr;
        $i=0;
        if($res)
        {
            foreach($res as $row)
                {
                    $resArr[$i] = $this->GetById($row["id"]);
                    $i++;
                }
        }
            
        return $resArr;
    }
    
    public function GetUserGroupDocTemplatesFromParentGroup($childGroup)
    {
         $res = false;
        /* @var $childGroup UserGroup */
         $query = "select id,name,idUserGroups,idDocTemplate,startDate,endDate,status 
                  from groups_docs where idUserGroups = ".$childGroup->idParentGroup;
         
         $templates = SqlHelper::ExecSelectCollectionQuery($query);
         if($templates )
         {
             $i = 0;
             foreach ($templates as $obj)
             {
                 /* @var usrGTD UserGroupDocTemplates */             
                 $usrGTD = new UserGroupDocTemplates(
                        $obj["idUserGroups"],
                        $obj["idDocTemplate"],
                        $obj["name"],
                        $obj["startDate"],
                        $obj["endDate"],
                        $obj["status"],
                        $obj["id"]
                    );
                 $res[$i] = $usrGTD;
                 $i++;
             }
             return $res;
         }
         else
             return false;
                
    }
    
    public function GetError()
    {
        return $this->error;
    }
}

?>
