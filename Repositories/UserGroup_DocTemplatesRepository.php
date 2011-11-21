<?php

/**
 * Description of UserGroup_DocTemplatesRepository
 *
 * @author Dmitry
 */
class UserGroup_DocTemplatesRepository implements IObjectRepository
{
    private $error;
    const TBL_USERGROUPS_DOCTEMPLATES = 'usergroups_doctemplates';
    
    public function Save($obj) 
    {
        /* @var $obj UserGroup_DocTemplates */
        if( isset($obj->id) && $obj->id > 0 )
        {
            $query = "update ".UserGroup_DocTemplatesRepository::TBL_USERGROUPS_DOCTEMPLATES." set 
                            idUserGroups = ".intval($obj->idUserGroups).",
                            idDocTemplate = ".intval($obj->idDocTemplate).",
                            name = '".ToolsHelper::CleanInputString($obj->name)."',
                            startDate = '".ToolsHelper::CleanInputString($obj->startDate)."',
                            endDate  = '".ToolsHelper::CleanInputString($obj->endDate)."' ,
                            status = ".intval($obj->status)."
                      where id = ".intval($obj->id);
            
            $numRows = SqlHelper::ExecUpdateQuery($query);
                                
            if(!$numRows)
            {
                $this->error = "При обновлении шаблонов документов для группы пользователей произошла ошибка!";
                NotificationHelper::LogCritical("Error in class: '".__CLASS__."' method: '".__METHOD__."' query: '$query'");                    
                return false;
            }            
        }
        else
        {
            $query = "insert into ".UserGroup_DocTemplatesRepository::TBL_USERGROUPS_DOCTEMPLATES." (idUserGroups,idDocTemplate,name,startDate,endDate,status)
                      values (
                                ".intval($obj->idUserGroups).",
                                ".intval($obj->idDocTemplate).",
                                '".ToolsHelper::CleanInputString($obj->name)."',
                                '".ToolsHelper::CleanInputString($obj->startDate)."',
                                '".ToolsHelper::CleanInputString($obj->endDate)."',
                                ".intval($obj->status)."
                             )";
            $newid = SqlHelper::ExecInsertQuery($query);
            $obj->id = $newid;
            
            if(!$newid)
            {
                $this->error = "При сохранении шаблона документа для пользовательской группы возникла ошибка!";
                NotificationHelper::LogCritical("Error in class: '".__CLASS__."' method: '".__METHOD__."' query: '$query'");                
                return false;
            }            
        }       
        return true;
    }
    
    public function Delete($obj)
    {
          /* @var $obj UserGroup_DocTemplates */
        $user = $obj;
        $query = "update ".UserGroup_DocTemplatesRepository::TBL_USERGROUPS_DOCTEMPLATES." 
                  set status = ".DbRecordStatus::DELETED." 
                  where id =". intval($obj->id);
        $rowNum = SqlHelper::ExecDeleteQuery($query);
                
        if (!$rowNum)
        {
            $this->error = "При удалении шаблона документа для пользовательской группы возникла ошибка!";
            NotificationHelper::LogCritical("Error in class: '".__CLASS__."' method: '".__METHOD__."' query: '$query'");
            return false;
        }
        return true;
    }
    
    public function GetById($id) 
    {
          $query = "select id, name, idUserGroups, idDocTemplate, startDate, endDate, status
                  from ".UserGroup_DocTemplatesRepository::TBL_USERGROUPS_DOCTEMPLATES."  where id = ".intval($id)."
                  and status = ".DbRecordStatus::ACTIVE;
        
        $res = SqlHelper::ExecSelectRowQuery($query);
        
        if($res)
        {
            /* @var $item UserGroup_DocTemplates */
            $item = new UserGroup_DocTemplates(
                        $res["idUserGroups"],
                        $res["idDocTemplate"],
                        $res["name"],
                        $res["startDate"],
                        $res["endDate"],
                        $res["status"],
                        $res["id"]
                    );
            return $item;
        }
        return false;
    }
    
    public function CheckForExists($obj)
    {
          /* @var $obj UserGroup_DocTemplates */
        
        $query = "select id from ".UserGroup_DocTemplatesRepository::TBL_USERGROUPS_DOCTEMPLATES." 
                  where idUserGroups='".ToolsHelper::CleanInputString($obj->idUserGroups)."' 
                        and idDocTemplate = '".ToolsHelper::CleanInputString($obj->idDocTemplate)."'";
        $obj = SqlHelper::ExecSelectValueQuery($query);
        
        if ($obj)
            return true;
        else 
            return false;  
    }
    
    public function GetListByUserGroupId($usrGroupID)
    {
         $query = "select id, name, idUserGroups, idDocTemplate, startDate, endDate, status
                  from usergroups_doctemplates where idUserGroups = ".intval($usrGroupID)."
                  and status = ".DbRecordStatus::ACTIVE;
        
        $res = SqlHelper::ExecSelectCollectionQuery($query);
        $i=0;      
        if($res)
        {
            $docTemplatesCollection = Array();
            foreach($res as $row)
            {
                /* @var $item UserGroup_DocTemplates */
                $item = new UserGroup_DocTemplates(
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
            return $docTemplatesCollection;
        }
        return false;
    }
    
     public function GetList($pageSize = 1, $pageNum = 1, $status = null)
    {
        $retArr = false;
        $query = "select id from ".UserGroup_DocTemplatesRepository::TBL_USERGROUPS_DOCTEMPLATES." ";
                                
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
    
    public function GetError()
    {
        return $this->error;
    }
}

?>
