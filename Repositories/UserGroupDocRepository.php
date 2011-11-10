<?php


/**
 * Description of UserGroupDocRepository
 *
 * @author Павел
 */

class UserGroupDocRepository implements IObjectRepository
{        
    private $error;
    private $TBL_DOCSTARAGE="docstorage";
    private $TBL_DOCSTARAGE_FIELDS="docstorage_fields";
    private $TBL_DOCSTORAGE_HISTORY="docstorage_history";
    
    function Save($obj)
    {
        $idList = "-1";
        /* @var $userGroupDoc UserGroupDoc */
        $userGroupDoc = $obj;
        if($userGroupDoc)
        {
            $sqlCon = SqlHelper::StartTransaction();
            
            //TODO: разобраться, что такое idGroupDocs
                $rep = new UserGroupRepository;
                $usergroups_docsID = $rep->GetUserGroupsDocTemplatesID($userGroupDoc->group->idParentGroup, $userGroupDoc->groupDocTempl->id);
                
                
            if(!$userGroupDoc->id)
            {                                
                $query = "INSERT INTO `".$this->TBL_DOCSTARAGE."` (`IdAuthor`, `IdGroup`, 
                    `IdGroupDocs`, `Status`, `DateCreated`, `LastChangedDate`) 
                VALUES ('".
                    intval($userGroupDoc->author->id)."','".
                    intval($userGroupDoc->group->id)."','".
                    //intval($userGroupDoc->groupDocTempl->id)."','".
                    intval($usergroups_docsID)."','".
                    intval($userGroupDoc->status)."',
                    'NOW()','NOW()')";
                $userGroupDoc->id = SqlHelper::ExecInsertQuery($query, $sqlCon);
                
                if( !$userGroupDoc->id)
                {
                    SqlHelper::RollbackTransaction($sqlCon);
                    $this->error = "При добавлении шаблона документа возникла ошибка!";
                    return false;
                }
                foreach($userGroupDoc->fieldsList as $val)
                {
                $query = "INSERT INTO `".$this->TBL_DOCSTARAGE_FIELDS."` (`idDocumentStorage`, `idDocTemplateField`, 
                    `StringValue`, `IntValue`, `BoolValue`) 
                VALUES ('".
                    intval($userGroupDoc->id)."','".
                    intval($val->docTemplateField->id)."','".
                    $val->stringValue."','".
                    $val->intValue."','".
                    $val->boolValue."')";
                $val->id = SqlHelper::ExecInsertQuery($query, $sqlCon);
                }
            }
            else
            {
//                $query = "UPDATE `".$this->TBL_DOCSTARAGE."` SET (`IdAuthor`, `IdGroup`, 
//                    `IdGroupDocs`, `Status`, `DateCreated`, `LastChangedDate`) VALUES ('".
//                    intval($userGroupDoc->author->id)."','".
//                    intval($userGroupDoc->group->id)."','".
//                    //intval($userGroupDoc->groupDocTempl->id)."','".
//                    intval($usergroups_docsID)."','".
//                    intval($userGroupDoc->status)."','".
//                    ToolsHelper::CleanInputString($userGroupDoc->dateCreated)."','
//                    NOW()') WHERE `id`='".$userGroupDoc->id."'";
                $query = "UPDATE `".$this->TBL_DOCSTARAGE."` SET `IdAuthor`=".intval($userGroupDoc->author->id).", 
                        `IdGroup`=".intval($userGroupDoc->group->id).", 
                    `IdGroupDocs` =". intval($usergroups_docsID).",
                     `Status` = ".intval($userGroupDoc->status).", 
                     `LastChangedDate` = NOW()                  
                      WHERE `id`='".$userGroupDoc->id."'";
                $rcount = SqlHelper::ExecUpdateQuery($query, $sqlCon);
                if($rcount < 1)
                {
                    SqlHelper::RollbackTransaction($sqlCon);
                    $this->error = "При добавлении документа возникла ошибка!";
                    return false;
                }
                $query = "DELETE FROM docstorage_fields  WHERE idDocumentStorage=".$userGroupDoc->id;
                $dCount = SqlHelper::ExecDeleteQuery($query, $sqlCon);
               
                foreach($userGroupDoc->fieldsList as $val)
                {
                $query = "INSERT INTO docstorage_fields (idDocumentStorage,idDocTemplateField,StringValue) VALUES ('".$userGroupDoc->id."','".$val->docTemplateField->id."','".$val->GetValue()."')";
                $vCount = SqlHelper::ExecUpdateQuery($query, $sqlCon);
                if($vCount < 1)
                {
                    SqlHelper::RollbackTransaction($sqlCon);
                    $this->error = "При добавлении поля документа возникла ошибка!";
                    return false;
                }
                }
            }
            
           SqlHelper::CommitTransaction($sqlCon);
           return $userGroupDoc->id;
        }
        return false;
    }
    
    function Delete($obj,$uId = null)
    {           
         /* @var $duserGroupDoc UserGroupDoc */
        $userGroupDoc = $obj;
        if($userGroupDoc)
        {
//            if(!$userGroupDoc->ValidateObjectTypes())
//            {
//                $this->error = "Системная шибка при удалении  документа (ошибка типов полей)";
//                NotificationHelper::LogCritical($this->error);
//                return false;
//            }
            $sqlCon = SqlHelper::StartTransaction();
            $query = "UPDATE `".$this->TBL_DOCSTARAGE."` SET `Status`='".
                    EnUserGroupDocStatus::DELETED."' WHERE `Id` ='".intval($userGroupDoc->id)."'";
            $rowNum = SqlHelper::ExecUpdateQuery($query,$sqlCon);
            if (!$rowNum)
            {
                SqlHelper::RollbackTransaction($sqlCon);
                $this->error = "При удалении документа возникла ошибка!";
                return false;
            }
            $query = "INSERT INTO `".$this->TBL_DOCSTORAGE_HISTORY."` (`IdDocument`,
                `IdUser`, `NewStatus`) VALUES ('".
                    intval($userGroupDoc->id)."','".
                    intval($uId)."','".
                    EnUserGroupDocStatus::DELETED."')";
            $rowId = SqlHelper::ExecInsertQuery($query,$sqlCon);
            if (!$rowId)
            {
                SqlHelper::RollbackTransaction($sqlCon);
                $this->error = "При удалении документа возникла ошибка!";
                return false;
            }
            SqlHelper::CommitTransaction($sqlCon);
            return $rowNum;
        }
    }
    
    function GetByID($id)
    {
        $userRep = new UserRepository;
        $userGroupRep = new UserGroupRepository;
        $docTemplRep = new DocTemplateRepository;
        //Добавить либо репозиторий либо переписать метод инициализации userGroupDocTemplate
        //$groupDocTemplsRep = new UserGroupDocTemplatesRepository;
        $groupDocTemplsRep = new DocTemplateRepository;
                       
        $query = "SELECT id, status, DateCreated, LastChangedDate, idAuthor, idGroup , idGroupDocs FROM ".$this->TBL_DOCSTARAGE." WHERE id='".intval($id)."'";
        $row = SqlHelper::ExecSelectRowQuery($query);
        if($row)
        {
            //костыль!!!!
            $q = " select idDocTemplate from usergroups_doctemplates where id=".$row['idGroupDocs'];
            $docTemplID = SqlHelper::ExecSelectValueQuery($q);
            //                        
            
            $doc = new UserGroupDoc();
            
            $doc->id = $row['id'];
            $doc->status = $row['status'];
            $doc->dateCreated = $row['DateCreated'];
            $doc->lastChangedDate = $row['LastChangedDate'];
            $doc->author = $userRep->GetById( intval($row['idAuthor']) );
            $doc->group = $userGroupRep->GetById( intval($row['idGroup']) );
            //$doc->groupDocTempl = $groupDocTemplsRep->GetById( intval($row['idGroupDocs']) );
            $doc->groupDocTempl = $groupDocTemplsRep->GetById( $docTemplID );
            
            $query = "SELECT * FROM `".$this->TBL_DOCSTARAGE_FIELDS."` WHERE `IdDocumentStorage`='".
                    intval($doc->id)."'";
            $datatable = SqlHelper::ExecSelectCollectionQuery($query);
            if($datatable)
            {
                foreach($datatable as $row)
                {
                    /* @var $fld UserGroupDocField */
                    $fld = new UserGroupDocField;
                    $fld->id = intval($row['id']);
                    $fld->docTemplateField = $docTemplRep->GetDocTemplateFieldById($row['idDocTemplateField']);
                    $fld->stringValue = $row['StringValue'];
                    $fld->intValue = $row['IntValue'];
                    $fld->boolValue = $row['BoolValue'];
                    $doc->fieldsList[] = $fld;
                }
                return $doc;
            }
            else
            {
                $this->error = "При загрузке полей документа возникла ошибка!";
                return false;
            }
        }
        else
        {
            $this->error = "При загрузке документа возникла ошибка!";
            return false;
        }
    }
    
      
    public function GetList($pageSize = 1, $pageNum = 1, $status = null)
    {                    
        //если pageSize = 1 - выводим всех
        $retArr = false;
        //менять на idGroup
        $query = "select id,idAuthor,idGroup,status,DateCreated,LastChangedDate from docstorage where idAuthor = '".LoginHelper::GetCurrentUserId()."'";
        if($status)
            $query.=" and status = $status";
        
        if($pageSize > 1)        
            $query.=" limit ".((int)$pageNum * (int)$pageSize).",".$pageSize;                
                                
        $res = SqlHelper::ExecSelectCollectionQuery($query);
        $i=0;
        if($res)
        {
            foreach($res as $row)
            {
                $doc = $this->GetByID($row['id']);
                                
                $retArr[$i] = $doc;
                $i++;
            }
        }
        
        if($retArr)
            return $retArr;
        else
        {
            $this->error = "Сохранённых документов не найдено";
            return false;
        }        
    }
      
    public function GetListItemsCount($status = null)
    {
        $query = "select count(*)
                  from docstorage where idAuthor = '".LoginHelper::GetCurrentUserId()."'";
        if($status)
            $query.="  and status = $status";        
        $res = SqlHelper::ExecSelectValueQuery($query);
        
        if($res)
            return $res;
        else return 0;
    }
    
    function CheckForExists($obj)
    {
        //TODO: Add logic!
        return false;
    }
    
    public function GetError()
    {
        return $this->error;
    }
    
}

?>
