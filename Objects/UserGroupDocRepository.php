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
        
    }
    
    function Delete($obj)
    {
         /* @var $duserGroupDoc UserGroupDoc */
        $userGroupDoc = $obj;
        if($userGroupDoc)
        {
           
            $query = "UPDATE `".$this->TBL_DOCSTARAGE."` SET `Status`='".EnUserGroupDocStatus::DELETED."' WHERE `Id` ='".intval($userGroupDoc->id)."'";
            $rowNum = SqlHelper::ExecUpdateQuery($query);
            if (!$rowNum)
            {
                $this->error = "При удалении документа возникла ошибка!";
                return false;
            }
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
