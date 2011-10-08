<?php


/**
 * Description of UserGroupDocumentRepository
 *
 * @author Павел
 */

class UserGroupDocumentRepository implements IObjectRepository
{        
    private $error;
    private $TBL_DOCSTARAGE="docstorage";
    private $TBL_DOCSTARAGE_FIELDS="docstrorage_fields";
    private $TBL_DOCSTORAGE_HISTORY="docstoragehistory";
    
    function Save($obj)
    {
        
    }
    
    function Delete($obj)
    {
        
    }
    
    
    function GetByID($id)
    {
        $userRep = new UserRepository;
        $groupDocsRep = new UserGroupDocumentRepository;
        /* @var $doc UserGroupDocument */
        $doc = new UserGroupDocument;
        
        
        $query = "SELECT * FROM `".$this->TBL_DOCSTARAGE."` WHERE `Id`='".intval($id)."'";
        $row = SqlHelper::ExecSelectRowQuery($query);
        if($row)
        {
            $doc->Id = $row['Id'];
            $doc->Status = $row['Status'];
            $doc->DateCreated = $row['DateCreated'];
            $doc->LastChangedDate = $row['LastChangeDate'];
            $doc->Author = $userRep->GetById( intval($row['IdAuthor']) );
            //$doc->Group = $groupRep->GetById( intval($row['IdGroup']) );
            //$doc->GroupDoc = $doc->Group->GetRelatedDocTemplates()
            
            $query = "SELECT * FROM `".$this->TBL_DOCSTARAGE_FIELDS."` WHERE `IdDocumentStorage`='".
                    intval($doc->Id)."'";
            $datatable = SqlHelper::ExecSelectCollectionQuery($query);
            if($datatable)
            {
                foreach($datatable as $row)
                {
                    /* @var $fld UserGroupDocumentField */
                    $fld = new UserGroupDocumentField;
                    $fld->Id = intval($row['Id']);
//                    $fld->Doc
//                    $fld->IsCalculated = (bool)$row['IsCalculated'];
//                    $fld->FieldType = $this->docTemplateFieldTypesArr[intval($row['IdFieldType'])];
//                    $fld->IsRestricted = (bool)$row['IsRestricted'];
//                    $fld->MaxVal = intval($row['MaxVal']);
//                    $fld->MinVal = intval($row['MinVal']);
//                    $fld->Operation = $this->docTemplateOperationsArr[intval($row['IdOperation'])];
                    $docTempl->fieldsList[$fld->Id] = $fld;
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
