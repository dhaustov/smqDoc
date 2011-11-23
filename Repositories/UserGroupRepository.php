<?php

/**
 * Description of UserGroupRepository
 *
 * @author Dmitry
 */
class UserGroupRepository implements IObjectRepository
{
    private $error;
    
    const TBL_USERGROUPS = "usergroups";
    /*
     * IObjectRepository Methods
     */    
    public function Save($obj)  
    { 
        /* @var $obj UserGroup */
        $tr = SqlHelper::StartTransaction();
        
        if( $obj->id > 0 ) //Updating Existing UserGroup
        {                
                $query = "update ".UserGroupRepository::TBL_USERGROUPS." set                                                             
                              name = '".ToolsHelper::CleanInputString($obj->name)."',                             
                              idParentGroup = '".ToolsHelper::CleanInputString($obj->idParentGroup)."', 
                              idMasterUserAccount = '".ToolsHelper::CleanInputString($obj->idMasterUserAccount)."', 
                              masterUserAccountRole = '".ToolsHelper::CleanInputString($obj->masterUserAccountRole)."',
                              status = '".ToolsHelper::CleanInputString($obj->status)."'
                          where id =". intval($obj->id);
                
                $numRows = SqlHelper::ExecUpdateQuery($query);
                
                if(!$numRows)
                {
                    SqlHelper::RollbackTransaction($tr);
                    $this->error = "При обновлении группы пользователей произошла ошибка!";
                    NotificationHelper::LogCritical("Error in class: '".__CLASS__."' method: '".__METHOD__."' query: '$query'");
                    return false;
                }         
        }
        else //Trying to save new user group
        {
            if($this->CheckForExists($obj))
            {
                $this->error = "Такая группа уже существует";
                return false;
            }

            $query = "insert into ".UserGroupRepository::TBL_USERGROUPS." (name, idParentGroup, idMasterUserAccount, masterUserAccountRole, status) 
                                  values ( '".ToolsHelper::CleanInputString($obj->name)."',
                                           '".ToolsHelper::CleanInputString($obj->idParentGroup)."',
                                           '".ToolsHelper::CleanInputString($obj->idMasterUserAccount)."',
                                           '".ToolsHelper::CleanInputString($obj->masterUserAccountRole)."',
                                           '".ToolsHelper::CleanInputString($obj->status)."'      
                                          )";

            $newid = SqlHelper::ExecInsertQuery($query);
            
            if(!$newid)
            {
                SqlHelper::RollbackTransaction($tr);
                $this->error = "При сохранении пользовательской группы возникла ошибка!";
                NotificationHelper::LogCritical("Error in class: '".__CLASS__."' method: '".__METHOD__."' query: '$query'");
                return false;
            }
            $obj->id = $newid;
        }
        
        //Разбираемся со связанными темплейтами
        $gtRep = new UserGroup_DocTemplatesRepository();
        $delFilter = "";
        $innerError = false;
        $lstTPL = $obj->GetRelatedDocTemplates();

        for($i=0; $i<count($lstTPL); $i++) 
        {
            /* @var $lstTPL[$i] $userGroup_DocTemplate */
            $lstTPL[$i]->idUserGroups = $obj->id; //задаём id группы            
            $tmpElem = $lstTPL[$i];
            if($gtRep->Save($tmpElem))
            {
                $lstTPL[$i] = $tmpElem;
                $delFilter .= " ".$lstTPL[$i]->id;
                if($i!=count($lstTPL)-1)
                    $delFilter .= ",";
            }
            else
            {
                SqlHelper::RollbackTransaction($tr);
                $this->error = $gtRep->GetError();
                NotificationHelper::LogCritical("Error in class: '".__CLASS__."' method: '".__METHOD__."' saving usergoups_doctemplates ");
                return false;
            }                    
        }


            $delQuery = "delete from ".UserGroup_DocTemplatesRepository::TBL_USERGROUPS_DOCTEMPLATES." 
                         where idUserGroups = ".intval($obj->id);

            if($delFilter!="")
                 $delQuery .=" and id not in ($delFilter) ";
            
             NotificationHelper::LogCritical($delQuery);
            $rc = SqlHelper::ExecDeleteQuery($delQuery);

            if(!$rc)
            {
                SqlHelper::RollbackTransaction($tr);
                $this->error = "При сохранении шаблонов документов для пользовательской группы возникла ошибка!";
                NotificationHelper::LogCritical("Error in class: '".__CLASS__."' method: '".__METHOD__."' query: '$delQuery'");
                return false;
            }


        $obj->AddRelatedDocTemplates($lstTPL);                                
        SqlHelper::CommitTransaction($tr);    
        return true;
    }
    
    public function Delete($obj)
    { 
        /* @var $obj UserGroup */        
        $query = "update ".UserGroupRepository::TBL_USERGROUPS." set status = ".EnUserGroupDocStatus::DELETED." where id =". intval($obj->id);
        $rowNum = SqlHelper::ExecDeleteQuery($query);
                
        $obj->status = EnUserGroupDocStatus::DELETED;
        if (!$rowNum)
        {
            $this->error = "При удалении группы возникла ошибка!";
            NotificationHelper::LogCritical("Error in class: '".__CLASS__."' method: '".__METHOD__."' query: '$query'");
            return false;
        }
        return true;
    }
   
    public function GetById($id) 
    { 
        /* @var $usrGroup UserGroup */        
        $query = "select id,name,idParentGroup,idMasterUserAccount,masterUserAccountRole,status 
                  from ".UserGroupRepository::TBL_USERGROUPS." 
                  where id = ". intval($id);
        $obj = SqlHelper::ExecSelectRowQuery($query);
        
        if ($obj)
        {
            $gtRep = new UserGroup_DocTemplatesRepository();
            $usrGroup = new UserGroup($obj['idMasterUserAccount']);
            
            $usrGroup->id = $obj['id'];            
            $usrGroup->idParentGroup = $obj['idParentGroup'];
            $usrGroup->status = $obj['status'];
            $usrGroup->name = $obj['name'];
            $usrGroup->masterUserAccountRole = $obj['masterUserAccountRole'];                                   
            $usrGroup->AddRelatedDocTemplates($gtRep->GetListByUserGroupId($usrGroup->id));
            
            return $usrGroup;
        }
        else 
        {
            $this->error = "Группа не найдена";
            return new UserGroup();
        }        
    }
            
    public function CheckForExists($obj)
    { 
        /* @var $obj UserGroup */                
        $query = "select id from ".UserGroupRepository::TBL_USERGROUPS." 
                  where name='".ToolsHelper::CleanInputString($obj->name)."' 
                        and idMasterUserAccount = '".ToolsHelper::CleanInputString($obj->idMasterUserAccount)."'";
        $res = SqlHelper::ExecSelectValueQuery($query);
        
        if ($res)
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
        $query = "select id from ".UserGroupRepository::TBL_USERGROUPS." ";
                                
        if($status)
            $query.="  where status = $status";        
        
        if($pageSize > 1)        
            $query.=" limit ".((int)$pageNum * (int)$pageSize).",".$pageSize;        
        
        $res = SqlHelper::ExecSelectCollectionQuery($query);        
        if($res)
        {
            //$retArr = Array();
            foreach($res as $row)            
                $retArr[] = $this->GetById($row["id"]);            
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
                  from ".UserGroupRepository::TBL_USERGROUPS." ";
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
        $query = "select id
                  from ".UserGroupRepository::TBL_USERGROUPS." 
                  where idMasterUserAccount = ".intval($masterUserAccountId);
        if($status)
            $query.=" and status = $status";
        $res = SqlHelper::ExecSelectCollectionQuery($query);        
        if($res)
        {
            foreach($res as $row)            
                $retArr[] = $this->GetById($row['id']);                         
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
    
    
    //!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
//    public function SaveUserGroupDocTemplate($obj)
//    {
//        /* @var $usrGroupDocTemplate UserGroup_DocTemplates */
//        $usrGroupDocTemplate = $obj;
//        if( $usrGroupDocTemplate->id > 0 )
//        {
//            $query = "update usergroups_doctemplates set 
//                            idUserGroups = ".intval($usrGroupDocTemplate->idUserGroups).",
//                            idDocTemplate = ".intval($usrGroupDocTemplate->idDocTemplate).",
//                            name = ".ToolsHelper::CleanInputString($usrGroupDocTemplate->name).",
//                            startDate = ".ToolsHelper::CleanInputString($usrGroupDocTemplate->startDate).",
//                            endDate  = ".ToolsHelper::CleanInputString($usrGroupDocTemplate->endDate)." ,
//                            status = ".intval($userGroupDocTemplate->status)."
//                      where id = ".intval($usr);
//            //==DbRecordStatus::DELETED ? DbRecordStatus::DELETED : DbRecordStatus::ACTIVE.
//             $numRows = SqlHelper::ExecUpdateQuery($query);
//                                
//                if(!$numRows)
//                {
//                    $this->error = "При обновлении шаблонов документов для группы пользователей произошла ошибка!";
//                    NotificationHelper::LogCritical("Error in class: '".__CLASS__."' method: '".__METHOD__."' query: '$query'");                    
//                }
//                return $usrGroupDocTemplate->id;
//        }
//        else
//        {
//            $query = "insert into usergroups_doctemplates (idUserGroups,idDocTemplate,name,startDate,endDate,status)
//                      values (
//                                ".intval($usrGroupDocTemplate->idUserGroups).",
//                                ".intval($usrGroupDocTemplate->idDocTemplate).",
//                                '".ToolsHelper::CleanInputString($usrGroupDocTemplate->name)."',
//                                '".ToolsHelper::CleanInputString($usrGroupDocTemplate->startDate)."',
//                                '".ToolsHelper::CleanInputString($usrGroupDocTemplate->endDate)."',
//                                ".intval($usrGroupDocTemplate->status)."
//                             )";
//            $newid = SqlHelper::ExecInsertQuery($query);
//
//            if(!$newid)
//            {
//                $this->error = "При сохранении шаблона документа для пользовательской группы возникла ошибка!";
//                NotificationHelper::LogCritical("Error in class: '".__CLASS__."' method: '".__METHOD__."' query: '$query'");                
//            }
//            return $newid;
//        }
//        
//        return false;
//    }
//    
//    public function LoadDocTemplatesCollection($obj)
//    {
//        /* @var $usrGroup UserGroup */
//        $usrGroup = $obj;
//        $docTemplatesCollection = false;
//        
//        $query = "select id, name, idUserGroups, idDocTemplate, startDate, endDate, status
//                  from usergroups_doctemplates where idUserGroups = ".intval($usrGroup->id)."
//                  and status = ".DbRecordStatus::ACTIVE;
//        
//        $res = SqlHelper::ExecSelectCollectionQuery($query);
//        $i=0;      
//        //echo "count res - ".count($res)."<br />";
//        if($res)
//        {
//            foreach($res as $row)
//            {
//                /* @var $item User_DocTemplates */
//                $item = new UserGroup_DocTemplates(
//                            $row["idUserGroups"],
//                            $row["idDocTemplate"],
//                            $row["name"],
//                            $row["startDate"],
//                            $row["endDate"],
//                            $row["status"],
//                            $row["id"]
//                        );
//                $docTemplatesCollection[$i] = $item;
//                $i++;
//            }
//        }
//        $usrGroup->AddRelatedDocTemplates($docTemplatesCollection);        
//        return $usrGroup;
//    }
//    
//    public function AddNewDocTemplateToCollection($obj, $templateID, $name=null, $startDate = null, $endDate = null)
//    {
//        /* @var $usrGroups UserGroup */
//        $usrGroups = $obj;   
//        /* @var $usrGroupsDocTemplate UserGroup_DocTemplates */
//        $usrGroupsDocTemplate = new UserGroup_DocTemplates(
//                    $usrGroups->id,
//                    $templateID,
//                    $name,
//                    $startDate,
//                    $endDate
//                );
//        $newID = $this->SaveUserGroupDocTemplate($usrGroupsDocTemplate);
//        //echo "newID: $newID <br />";
//        if($newID > 0)
//        {
//            $usrGroups = $this->LoadDocTemplatesCollection($usrGroups);
//            return $usrGroups;
//            //return true;
//        }        
//        return false;
//    }        
//    
//    public function DeleteDocTemplateFromCollection($obj, $templateID)
//    {
//        /* @var $usrGroups UserGroup */
//        $usrGroups = $obj;   
//        
//        $query = "update usergroups_doctemplates set status = ".DbRecordStatus::DELETED."
//                    where idDocTemplate = ".intval($templateID)." 
//                      and idUserGroups = ".intval($obj->id)." ";
//        
//        $numRows = SqlHelper::ExecUpdateQuery($query);
//                                
//        if(!$numRows)
//        {
//            $this->error = "При обновлении удалении шаблона документов для группы пользователей произошла ошибка!";
//            NotificationHelper::LogCritical("Error in class: '".__CLASS__."' method: '".__METHOD__."' query: '$query'");                    
//        }
//        else
//            {
//                $usrGroups = $this->LoadDocTemplatesCollection($usrGroups);
//                return $usrGroups;
//            }
//
//        return false;
//    }
            
    public function GetUserGroupDocTemplatesFromParentGroup($childGroup)
    {
         $res = false;
         $query = "select id,idDocTemplate
                  from usergroups_doctemplates where idGroup = ".$childGroup->idParentGroup;         
         $templates = SqlHelper::ExecSelectCollectionQuery($query);
         if($templates )
         {
             $i = 0;
             $rep = new DocTemplateRepository;
             foreach ($templates as $obj)
             {          
                 $usrGTD = $rep->GetByID($obj['idDocTemplate']);                  
                 $res[$i] = $usrGTD;
                 $i++;
             }
             return $res;
         }
         else
             return false;
                
    }
    
    /*
    public function GetUserGroupsDocTemplatesID($groupID, $tempID)
    {
         $res = false;
         $query = "select id from usergroups_doctemplates where idGroup = '".$groupID."' and idDocTemplate='".$tempID."'";
         $res = SqlHelper::ExecSelectValueQuery($query);
         return $res;
    }
      */
    
    /*Parents and children methods*/
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
        
        $query = "select id from ".UserGroupRepository::TBL_USERGROUPS." where idParentGroup =".intval($usrGrp->id);
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
            
     public function GetUserGroupsByMasterID($masterID)
     {
        $retArr = false;
        $query = "select id from ".UserGroupRepository::TBL_USERGROUPS." where idMasterUserAccount = ".$masterID;

        $res = SqlHelper::ExecSelectCollectionQuery($query);
        $i=0;
        if($res)
        {
            foreach($res as $row)
            {
                $usrGroup = $this->GetById($row['id']);                
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
     
    public function GetError()
    {
        return $this->error;
    }
}

?>
