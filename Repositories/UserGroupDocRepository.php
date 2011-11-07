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
    private $TBL_DOCSTARAGE_FIELDS="docstrorage_fields";
    private $TBL_DOCSTORAGE_HISTORY="docstoragehistory";
    
    function Save($obj)
    {
        $idList = "-1";
        /* @var $userGroupDoc UserGroupDoc */
        $userGroupDoc = $obj;
        if($userGroupDoc)
        {
//            if(!$userGroupDoc->ValidateObjectTypes())
//            {
//                $this->error = "Системная шибка при сохранении  документа (ошибка типов полей)";
//                NotificationHelper::LogCritical($this->error);
//                return false;
//            }
            $sqlCon = SqlHelper::StartTransaction();
            if($userGroupDoc->id > 0)
            {
                $query = "INSERT INTO `".$this->TBL_DOCSTARAGE."` (`IdAuthor`, `IdGroup`, 
                    `IdGroupDocs`, `Status`, `DateCreated`, `LastChangedDate`) 
                VALUES ('".
                    intval($userGroupDoc->author->id)."','".
                    intval($userGroupDoc->group->id)."','".
                    intval($userGroupDoc->groupDocTempl->id)."','".
                    intval($userGroupDoc->status)."',
                    'NOW()','NOW()')";
                $userGroupDoc->id = SqlHelper::ExecInsertQuery($query, $sqlCon);
                if($docTempl->id <= 0)
                {
                    SqlHelper::RollbackTransaction($sqlCon);
                    $this->error = "При добавлении шаблона документа возникла ошибка!";
                    return false;
                }
            }
            else
            {
                $query = "UPDATE `".$this->TBL_DOCSTARAGE."` SET (`IdAuthor`, `IdGroup`, 
                    `IdGroupDocs`, `Status`, `DateCreated`, `LastChangedDate`) VALUES ('".
                    intval($userGroupDoc->author->id)."','".
                    intval($userGroupDoc->group->id)."','".
                    intval($userGroupDoc->groupDocTempl->id)."','".
                    intval($userGroupDoc->status)."','".
                    ToolsHelper::CleanInputString($userGroupDoc->dateCreated)."','
                    NOW()') WHERE `id`='".$userGroupDoc->id."'";
                $userGroupDoc->id = SqlHelper::ExecInsertQuery($query, $sqlCon);
                if($docTempl->id <= 0)
                {
                    SqlHelper::RollbackTransaction($sqlCon);
                    $this->error = "При добавлении шаблона документа возникла ошибка!";
                    return false;
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
        $groupDocTemplsRep = new UserGroupDocTemplatesRepository;
        
        $doc = new UserGroupDocTemplates;
        
        $query = "SELECT * FROM `".$this->TBL_DOCSTARAGE."` WHERE `Id`='".intval($id)."'";
        $row = SqlHelper::ExecSelectRowQuery($query);
        if($row)
        {
            $doc->id = $row['Id'];
            $doc->status = $row['Status'];
            $doc->dateCreated = $row['DateCreated'];
            $doc->lastChangedDate = $row['LastChangeDate'];
            $doc->author = $userRep->GetById( intval($row['IdAuthor']) );
            $doc->group = $groupRep->GetById( intval($row['IdGroup']) );
            $doc->groupDocTempl = $groupDocTemplsRep->GetById( intval($row['IdGroupDocs']) );
            
            $query = "SELECT * FROM `".$this->TBL_DOCSTARAGE_FIELDS."` WHERE `IdDocumentStorage`='".
                    intval($doc->id)."'";
            $datatable = SqlHelper::ExecSelectCollectionQuery($query);
            if($datatable)
            {
                foreach($datatable as $row)
                {
                    /* @var $fld UserGroupDocField */
                    $fld = new UserGroupDocField;
                    $fld->id = intval($row['Id']);
                    /* @var $dfTempl DocTemplateField*/
//                    foreach((($doc->groupDocTempl)->docTemplateType)->fieldsList as $dfTempl)
//                    {
//                        if($dfTempl->Id == intval($row['IdDocTemplateField']))
//                            $fld->docTemplateField = &$dfTempl;
//                    }
                    $fld->docTemplateField = $docTemplRep->GetDocTemplateFieldById($row['IdDocTemplateField']);
                    $fld->stringValue = $row['StringValue'];
                    $fld->intValue = $row['IntValue'];
                    $fld->boolValue = $row['BoolValue'];
                    $docTempl->fieldsList[$fld->id] = $fld;
                }
                return $docTempl;
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
    
    function CheckForExists($obj)
    {
        
    }
    public function GetError()
    {
        return $this->error;
    }
    
}

?>
