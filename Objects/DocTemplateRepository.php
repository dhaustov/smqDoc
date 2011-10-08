<?php

/**
 * Description of DocTemplateRepository
 *
 * @author Павел
 */
class DocTemplateRepository implements IObjectRepository
{
    private $error="";
    private $TBL_DOCTEMPLATES="doctemplates";
    private $TBL_DOCTEMPLATE_FIELDS = "doctemplate_fields";
    private $TBL_DOCTEMPLATE_FIELD_TYPES = "doctemplate_fieldtypes";
    private $TBL_DOCTEMPLATE_FIELD_OPERATIONS = "doctemplate_operations";
    public $docTemplateFieldTypesArr = array();
    public $docTemplateOperationsArr = array();
    
    public function __construct() {
        $this->LoadDocTemplateFieldTypes();
        $this->LoadDocTemplateOperations();
    }
    
    public function LoadDocTemplateOperations()
    {
        //$this->docTemplateOperationsArr = array();
        $query = "SELECT * FROM `".$this->TBL_DOCTEMPLATE_FIELD_OPERATIONS."`";
        $datatable = SqlHelper::ExecSelectCollectionQuery($query);
        if($datatable)
        {
            foreach($datatable as $row)
            {
                /* @var $oper DocTemplateOperation */
                $oper = new DocTemplateOperation;
                $oper->Id = intval($row['Id']);
                $oper->Name = $row['Name'];
                $oper->Code = $row['Code'];
                $this->docTemplateOperationsArr[$oper->Id] = $oper;
            }
        }
        else
        {
            $this->error = "При загрузке шаблонов операций возникла ошибка!";
            return false;
        }
    }
    public function LoadDocTemplateFieldTypes()
    {
        //$this->docTemplateOperationsArr = array();
        $query = "SELECT * FROM `".$this->TBL_DOCTEMPLATE_FIELD_TYPES."`";
        $datatable = SqlHelper::ExecSelectCollectionQuery($query);
        if($datatable)
        {
            foreach($datatable as $row)
            {
                /* @var $tp DocTemplateFieldType */
                $tp = new DocTemplateFieldType;
                $tp->Id = intval($row['Id']);
                $tp->Name = $row['Name'];
                $tp->DataBaseType = $row['DataBaseType'];
                $this->docTemplateFieldTypesArr[$tp->Id] = $tp;
            }
        }
        else
        {
            $this->error = "При загрузке шаблонов типов полей возникла ошибка!";
            return false;
        }
    }
    
// <editor-fold defaultstate="collapsed" desc="редакторы справочников операций и типов полей">
//    public function SaveDocTemplateOperation($obj)
//    {
//        if($obj)
//        {
//            /* @var $oper DocTemplateOperation */
//            $oper = $obj;
//            if(intval($oper->Id) > 0)
//            {
//                $query = "UPDATE `".$this->TBL_DOCTEMPLATE_FIELD_OPERATIONS."` 
//                    SET (`Name`,`Code`) VALUES ('".$oper->Name."','".$oper->Code."') 
//                        WHERE `Id`='".intval($oper->Id)."'";
//                if(SqlHelper::ExecUpdateQuery($query))
//                {
//                    $this->LoadDocTemplateOperations();
//                    return true;
//                }
//                   
//            }
//            else
//            {
//                $query = "INSERT INTO `".$this->TBL_DOCTEMPLATE_FIELD_OPERATIONS.
//                        "` (`Name`,`Code`) VALUES ('".$oper->Name."','".$oper->Code."')";
//                $oper->Id = intval(SqlHelper::ExecInsertQuery($query));
//                if($oper->Id > 0)
//                {
//                    $this->LoadDocTemplateOperations();
//                    return true;
//                }
//            }
//        }
//        $this->error = "При сохранении шаблона операции возникла ошибка!";
//        return false;
//    }
//    public function SaveDocTemplateFieldType($obj)
//    {
//        if($obj)
//        {
//            /* @var $ft DocTemplateFieldType */
//            $ft = $obj;
//            if(intval($ft->Id) > 0)
//            {
//                $query = "UPDATE '".$this->TBL_DOCTEMPLATE_FIELD_TYPES."' 
//                    SET (Name,DataBaseType) VALUES (`".$oper->Name."`,`".$oper->DataBaseType."`) 
//                        WHERE 'Id'=".intval($ft->Id)."`";
//                if(SqlHelper::ExecUpdateQuery($query))
//                {
//                    $this->LoadDocTemplateFieldTypes();
//                    return true;
//                }
//                   
//            }
//            else
//            {
//                $query = "INSERT INTO '".$this->TBL_DOCTEMPLATE_FIELD_TYPES.
//                        "' (Name,DataBaseType) VALUES (`".$ft->Name."`,`".$ft->DataBaseType."`)";
//                $ft->Id = intval(SqlHelper::ExecInsertQuery($query));
//                if($ft->Id > 0)
//                {
//                    $this->LoadDocTemplateFieldTypes();
//                    return true;
//                }
//            }
//        }
//        $this->error = "При сохранении шаблона типа поля возникла ошибка!";
//        return false;
//    }
//    public function DeleteDocTemplateOperation($obj)
//    {
//        if($obj)
//        {
//            /* @var $oper DocTemplateOperation */
//            $oper = $obj;
//            if(intval($oper->Id) > 0)
//            {
//                $query = "DELETE FROM `".$this->TBL_DOCTEMPLATE_FIELD_OPERATIONS."`  
//                        WHERE `Id`='".intval($oper->Id)."'";
//                if(SqlHelper::ExecDeleteQuery($query))
//                {
//                    $this->LoadDocTemplateOperations();
//                    return true;
//                }
//            }
//        }
//        $this->error = "При удалении шаблона операции возникла ошибка!";
//        return false;
//    }
//    public function DeleteDocTemplateFieldType($obj)
//    {
//        if($obj)
//        {
//            /* @var $ft DocTemplateFieldType */
//            $ft = $obj;
//            if(intval($ft->Id) > 0)
//            {
//                $query = "DELETE FROM '".$this->TBL_DOCTEMPLATE_FIELD_TYPES."'  
//                        WHERE 'Id'=".intval($ft->Id)."`";
//                if(SqlHelper::ExecDeleteQuery($query))
//                {
//                    $this->LoadDocTemplateFieldTypes();
//                    return true;
//                }
//            }
//        }
//        $this->error = "При удалении шаблона типа поля возникла ошибка!";
//        return false;
//    }
    // </editor-fold>
    
    function Save($obj)
    {
        $IdList = "-1";
        if( count($this->docTemplateFieldTypesArr) == 0 )
        {
            $this->LoadDocTemplateFieldTypes();
        }
        if( count($this->docTemplateOperationsArr) == 0 )
        {
            $this->LoadDocTemplateOperations();
        }
        /* @var $docTempl DocTemplate */
        $docTempl = $obj;
        if($docTempl)
        {
           if(intval($docTempl->Id) > 0)
           {
            $query = "UPDATE `".$this->TBL_DOCTEMPLATES."`SET (`Name`) VALUES ('".$docTempl->Name."') WHERE `Id` ='".intval($docTempl->Id)."'";
            $rowNum = SqlHelper::ExecUpdateQuery($query);
            if (!$rowNum)
            {
                $this->error = "При изменении шаблона документа возникла ошибка!";
                return false;
            }
           }
           else
           {
            $query = "INSERT INTO `".$this->TBL_DOCTEMPLATES."` (`Name`) VALUES ('".$docTempl->Name."')";
            $docTempl->Id = intval(SqlHelper::ExecInsertQuery($query));
            if ($docTempl->Id <= 0)
            {
                $this->error = "При добавлении шаблона документа возникла ошибка!";
                return false;
            }
           }
           foreach($docTempl->fieldsList as $field)
           {
               /* @var $field DocTemplateField */
               if(intval($field->Id) > 0)
               {
                $query = "UPDATE `".$this->TBL_DOCTEMPLATE_FIELDS."`SET 
                    ( `Name`, `IsCalculated`, `IdFieldType`, `IsRestricted`, `MinVal`, `MaxVal`, `IdOperation`, `IdDocTemplate`) 
                    VALUES ('".$field->Name."','".intval($field->IsCalculated)."','".intval($field->FieldType->Id)."','".intval($field->IsRestricted)."','".
                    $field->MinVal."','".$field->MaxVal."','".intval($field->Operation->Id)."','".intval($docTempl->Id)."') WHERE `Id` ='".intval($field->Id)."'";
                $rowNum = SqlHelper::ExecUpdateQuery($query);
                if (!$rowNum)
                {
                    $this->error = "При изменении шаблона документа возникла ошибка!";
                    return false;
                }
                $IdList+=",'".$field->Id."'";
               }
               else
               {
                $prevId = $field->Id;
                $query = "INSERT INTO `".$this->TBL_DOCTEMPLATE_FIELDS."` ( `Name`, `IsCalculated`, `IdFieldType`, `IsRestricted`, `MinVal`, `MaxVal`, `IdOperation`, `IdDocTemplate`) 
                    VALUES ('".$field->Name."','".intval($field->IsCalculated)."','".intval($field->FieldType->Id)."','".intval($field->IsRestricted)."','".
                    $field->MinVal."','".$field->MaxVal."','".intval($field->Operation->Id)."','".$docTempl->Id."')";
                $field->Id = intval(SqlHelper::ExecInsertQuery($query));
                if ($field->Id <= 0)
                {
                    $this->error = "При добавлении шаблона документа возникла ошибка!";
                    return false;
                }
                unset($docTempl->fieldsList[$prevId]);
                $docTempl->fieldsList[$field->Id] = $field;
                
               }
                $query = "DELETE FROM `".$this->TBL_DOCTEMPLATE_FIELDS."` WHERE `Id` NOT IN (".$IdList.") AND `IdDocTemplate` = '".$docTempl->Id."'";
                $rowNum = SqlHelper::ExecDeleteQuery($query);
                if (!$rowNum)
                {
                    $this->error = "При изменении полей шаблона документа возникла ошибка!";
                    return false;
                }
           }
           return true;
        }
        return false;
    }
    
    function Delete($obj)
    {
        /* @var $docTempl DocTemplate */
        $docTempl = $obj;
        if($docTempl)
        {
           
            $query = "DELETE FROM `".$this->TBL_DOCTEMPLATES."` WHERE `Id` ='".intval($docTempl->Id)."'";
            $rowNum = SqlHelper::ExecDeleteQuery($query);
            if (!$rowNum)
            {
                $this->error = "При удалении шаблона документа возникла ошибка!";
                return false;
            }
            return $rowNum;
        }
    }
    
    function GetByID($id)
    {
        if( count($this->docTemplateFieldTypesArr) == 0 )
        {
            $this->LoadDocTemplateFieldTypes();
        }
        if( count($this->docTemplateOperationsArr) == 0 )
        {
            $this->LoadDocTemplateOperations();
        }
        /* @var $docTempl DocTemplate */
        $docTempl = new DocTemplate;
        
        $query = "SELECT * FROM `".$this->TBL_DOCTEMPLATES."` WHERE `Id`='".intval($id)."'";
        $row = SqlHelper::ExecSelectRowQuery($query);
        if($row)
        {
            $docTempl->Id = $row['Id'];
            $docTempl->Name = $row['Name'];
            $query = "SELECT * FROM `".$this->TBL_DOCTEMPLATE_FIELDS."` WHERE `IdDocTemplate`='".
                    intval($docTempl->Id)."'";
            $datatable = SqlHelper::ExecSelectCollectionQuery($query);
            if($datatable)
            {
                foreach($datatable as $row)
                {
                    /* @var $fld DocTemplateField */
                    $fld = new DocTemplateField;
                    $fld->Id = intval($row['Id']);
                    $fld->Name = $row['Name'];
                    $fld->IsCalculated = (bool)$row['IsCalculated'];
                    $fld->FieldType = $this->docTemplateFieldTypesArr[intval($row['IdFieldType'])];
                    $fld->IsRestricted = (bool)$row['IsRestricted'];
                    $fld->MaxVal = intval($row['MaxVal']);
                    $fld->MinVal = intval($row['MinVal']);
                    $fld->Operation = $this->docTemplateOperationsArr[intval($row['IdOperation'])];
                    $docTempl->fieldsList[$fld->Id] = $fld;
                }
                return $docTempl;
            }
            else
            {
                $this->error = "При загрузке шаблонов полей возникла ошибка!";
                return false;
            }
        }
        else
        {
            $this->error = "При загрузке шаблона документа возникла ошибка!";
            return false;
        }
    }
    
    function CheckForExists($obj)
    {
//        $query = "SELECT * FROM '".$this->TBL_DOCTEMPLATES."' WHERE 'id'=`".intval($id)."`";
//        $row = SqlHelper::ExecSelectRowQuery($query);
//        if($row)
//        {
//            return true;
//        }
//        else
//        {
//            return false;
//        }
    }
    
    public function GetError()
    {
        return $this->error;
    }
}

?>
