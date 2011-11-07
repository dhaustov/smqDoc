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
        $query = "SELECT * FROM `".$this->TBL_DOCTEMPLATE_FIELD_OPERATIONS."`";
        $datatable = SqlHelper::ExecSelectCollectionQuery($query);
        if($datatable)
        {
            foreach($datatable as $row)
            {
                /* @var $oper DocTemplateOperation */
                $oper = new DocTemplateOperation;
                $oper->id = intval($row['Id']);
                $oper->name = $row['Name'];
                $oper->code = $row['Code'];
                //if($oper->ValidateObjectTypes())
                $this->docTemplateOperationsArr[$oper->id] = $oper;
//                else
//                {
//                    $this->error = "Системная шибка при чтении шаблона операций документа (ошибка типов полей)";
//                    NotificationHelper::LogCritical($this->error);
//                }
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
        $query = "SELECT * FROM `".$this->TBL_DOCTEMPLATE_FIELD_TYPES."`";
        $datatable = SqlHelper::ExecSelectCollectionQuery($query);
        if($datatable)
        {
            foreach($datatable as $row)
            {
                /* @var $tp DocTemplateFieldType */
                $tp = new DocTemplateFieldType;
                $tp->id = intval($row['Id']);
                $tp->name = $row['Name'];
                $tp->dataBaseType = $row['DataBaseType'];
                //if($tp->ValidateObjectTypes())
                 $this->docTemplateFieldTypesArr[$tp->id] = $tp;
//                else
//                {
//                    $this->error = "Системная шибка при чтении типой полей шаблона документа (ошибка типов полей)";
//                    NotificationHelper::LogCritical($this->error);
//                }
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
        $idList = "'-1'";
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
//            if(!$docTempl->ValidateObjectTypes())
//            {
//                $this->error = "Системная ошибка при сохранении шаблона документа (ошибка типов полей)";
//                NotificationHelper::LogCritical($this->error);
//                return false;
//            }
           $sqlCon = SqlHelper::StartTransaction();
           if(intval($docTempl->id) > 0)
           {
            $query = "UPDATE `".$this->TBL_DOCTEMPLATES."` 
                         SET `Name` = '".ToolsHelper::CleanInputString($docTempl->name)."' 
                         WHERE `Id` ='".intval($docTempl->id)."'";
            $rowNum = SqlHelper::ExecUpdateQuery($query,$sqlCon);
            /*
            if (!$rowNum)
            {
                SqlHelper::RollbackTransaction($sqlCon);
                $this->error = "При изменении шаблона документа возникла ошибка! ";
                return false;
            }*/
           }
           else
           {
            $query = "INSERT INTO `".$this->TBL_DOCTEMPLATES."` (`Name`) VALUES 
                ('".ToolsHelper::CleanInputString($docTempl->name)."')";
            $docTempl->id = intval(SqlHelper::ExecInsertQuery($query,$sqlCon));
            if ($docTempl->id <= 0)
            {
                SqlHelper::RollbackTransaction($sqlCon);
                $this->error = "При добавлении шаблона документа возникла ошибка!";
                return false;
            }
           }
           foreach($docTempl->fieldsList as $field)
           {
               /* @var $field DocTemplateField */
               if(intval($field->id) > 0)
               {
                   $operID = 0;
                   if(isset($field->operation->id))
                           $operID = $field->operation->id;
                /*   
                $query = "UPDATE `".$this->TBL_DOCTEMPLATE_FIELDS."`SET 
                    ( `Name`, `IsCalculated`, `IdFieldType`, `IsRestricted`, `MinVal`, `MaxVal`, `IdOperation`, `IdDocTemplate`) 
                    VALUES ('".
                        ToolsHelper::CleanInputString($field->name)."','".
                        intval($field->isCalculated)."','".
                        intval($field->fieldType->id)."','".
                        intval($field->isRestricted)."','".
                        $field->minVal."','".
                        $field->maxVal."','".
                        intval($operID)."','".
                        intval($docTempl->id)."') WHERE `Id` ='".
                        intval($field->id)."'";                 
                 */
                
                $query = "update ".$this->TBL_DOCTEMPLATE_FIELDS." set 
                              Name = '".ToolsHelper::CleanInputString($field->name)."', 
                              IsCalculated = '".intval($field->isCalculated)."',
                              IdFieldType = '".intval($field->fieldType->id)."',
                              IsRestricted = '".intval($field->isRestricted)."',
                              MinVal = '".$field->minVal."',
                              MaxVal = '".$field->maxVal."',
                              IdOperation = '".intval($operID)."',
                              idDocTemplate = '". intval($docTempl->id)."'
                           where id = '".intval($field->id)."'";
                
                $rowNum = SqlHelper::ExecUpdateQuery($query,$sqlCon);
                /*
                if (!$rowNum)
                {
                    SqlHelper::RollbackTransaction($sqlCon);
                    $this->error = "При изменении шаблона документа возникла ошибка!";
                    return false;
                }*/
                
                $idList=$idList.",'".$field->id."'";
               }
               else
               {
                $prevId = $field->id;
                $operID = 0;
                   if(isset($field->operation->id))
                           $operID = $field->operation->id;
                   
                $query = "INSERT INTO `".$this->TBL_DOCTEMPLATE_FIELDS."` ( `Name`, `IsCalculated`, `IdFieldType`, `IsRestricted`, `MinVal`, `MaxVal`, `IdOperation`, `IdDocTemplate`) 
                    VALUES ('".
                        ToolsHelper::CleanInputString($field->name)."','".
                        intval($field->isCalculated)."','".
                        intval($field->fieldType->id)."','".
                        intval($field->isRestricted)."','".
                        $field->minVal."','".
                        $field->maxVal."','".
                        intval($operID)."','".
                        $docTempl->id."')";
                $field->id = intval(SqlHelper::ExecInsertQuery($query,$sqlCon));
                if ($field->id <= 0)
                {
                    SqlHelper::RollbackTransaction($sqlCon);
                    $this->error = "При добавлении шаблона документа возникла ошибка!";
                    return false;
                }
                unset($docTempl->fieldsList[$prevId]);
                $docTempl->fieldsList[$field->id] = $field;
                $idList=$idList.",'".$field->id."'";
               }
                
           }
           $query = "DELETE FROM `".$this->TBL_DOCTEMPLATE_FIELDS."` WHERE (`Id` NOT IN (".$idList.")) AND (`IdDocTemplate` = '".$docTempl->id."')";
                $rowNum = SqlHelper::ExecDeleteQuery($query,$sqlCon);
                if (is_null($rowNum))
                {
                    SqlHelper::RollbackTransaction($sqlCon);
                    $this->error = "При изменении полей шаблона документа возникла ошибка!";
                    return false;
                }
           SqlHelper::CommitTransaction($sqlCon);
           //return true;
           return $docTempl->id;
        }
        return false;
    }
    
    function Delete($obj)
    {
        /* @var $docTempl DocTemplate */
        $docTempl = $obj;
        
        if($docTempl && intval($docTempl->id) > 0)
        {
//           if(!$docTempl->ValidateObjectTypes())
//            {
//                $this->error = "Системная шибка при удалении шаблона документа (ошибка типов полей)";
//                NotificationHelper::LogCritical($this->error);
//                return false;
//            }
            $sqlCon = SqlHelper::StartTransaction();
            $query = "DELETE FROM `".$this->TBL_DOCTEMPLATES."` WHERE `Id` ='".intval($docTempl->id)."'";
            $rowNum = SqlHelper::ExecDeleteQuery($query,$sqlCon);
            if (!$rowNum)
            {
                SqlHelper::RollbackTransaction($sqlCon);
                $this->error = "При удалении шаблона документа возникла ошибка!";
                return false;
            }
            SqlHelper::CommitTransaction($sqlCon);
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
            $docTempl->id = $row['Id'];
            $docTempl->name = $row['Name'];
            $query = "SELECT * FROM `".$this->TBL_DOCTEMPLATE_FIELDS."` WHERE `IdDocTemplate`='".
                    intval($docTempl->id)."'";
            $datatable = SqlHelper::ExecSelectCollectionQuery($query);
            if($datatable)
            {
                foreach($datatable as $row)
                {
                    /* @var $fld DocTemplateField */
                    $fld = new DocTemplateField;
                    $fld->id = intval($row['Id']);
                    $fld->name = $row['Name'];
                    $fld->isCalculated = (bool)$row['IsCalculated'];
                    
                    if(intval($row['IdFieldType']) > 0)
                        $fld->fieldType = $this->docTemplateFieldTypesArr[intval($row['IdFieldType'])];
                    $fld->isRestricted = (bool)$row['IsRestricted'];
                    $fld->maxVal = intval($row['MaxVal']);
                    $fld->minVal = intval($row['MinVal']);
                    
                    if(intval($row['IdOperation']))
                        $fld->operation = $this->docTemplateOperationsArr[intval($row['IdOperation'])];
                    $docTempl->fieldsList[$fld->id] = $fld;
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
            $this->error = "При загрузке шаблона документа возникла ошибка! id =".$id;
            return false;
        }
    }
    
    function GetDocTemplateFieldById($id)
    {
      $query = "SELECT * FROM `".$this->TBL_DOCTEMPLATE_FIELDS."` WHERE `IdDocTemplate`='".
                    intval($docTempl->id)."'";
            $row = SqlHelper::ExecSelectCollectionQuery($query);
            if($row)
            {
                /* @var $fld DocTemplateField */
                $fld = new DocTemplateField;
                $fld->id = intval($row['Id']);
                $fld->name = $row['Name'];
                $fld->isCalculated = (bool)$row['IsCalculated'];
                $fld->fieldType = $this->docTemplateFieldTypesArr[intval($row['IdFieldType'])];
                $fld->isRestricted = (bool)$row['IsRestricted'];
                $fld->maxVal = intval($row['MaxVal']);
                $fld->minVal = intval($row['MinVal']);
                $fld->operation = $this->docTemplateOperationsArr[intval($row['IdOperation'])];
//                if(!$fld->ValidateObjectTypes())
//                {
//                    $this->error = "Системная шибка при чтении поля шаблона документа (ошибка типов полей) Id поля".$id;
//                    NotificationHelper::LogCritical($this->error);
//                }
                return $fld;
            }
            else
            {
                $this->error = "При загрузке шаблонов полей возникла ошибка!";
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
    
   public function GetListByGroupID($id)
   {
       $res = Array();
       $query = "select idDocTemplate  from userGroups_docTemplates where idGroup= '$id' ";
       $lst = SqlHelper::ExecSelectCollectionQuery($query);
       if($lst)
       {
           foreach($lst as $tid)
           {
               $res[] = $this->GetByID($tid["idDocTemplate"]);
           }
       }
       if(count($res) > 0)
           return $res;
       else
           return false;
   }
   public function GetList($pageSize = 1, $pageNum = 1, $status = null)
    {
        $retArr = false;
        $query = "select id,name from doctemplates ";
        
        /*
        if($status)
            $query.="  where status = $status";        
        */
        
        if($pageSize > 1)        
            $query.=" limit ".((int)$pageNum * (int)$pageSize).",".$pageSize;        
        
        $res = SqlHelper::ExecSelectCollectionQuery($query);
        $i=0;
        if($res)
        {
            foreach($res as $row)
            {
                $tpl = $this->GetByID($row['id']);               
                $retArr[$i] = $tpl;
                $i++;
            }
        }
        if($retArr)
            return $retArr;
        else
        {
            $this->error = "Шаблонов документов не найдено";
            return false;
        }        
    }
    
    public function GetListItemsCount($status = null)
    {
        $query = "select count(*) from doctemplates ";
        /*
        if($status)
            $query.="  where status = $status";        */
        
        $res = SqlHelper::ExecSelectValueQuery($query);
        
        if($res)
            return $res;
        else return 0;
    }
    
    public function GetError()
    {
        return $this->error;
    }
}

?>
