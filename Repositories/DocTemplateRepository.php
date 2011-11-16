<?php

/**
 * Description of DocTemplateRepository
 *
 * @author Павел
 */
class DocTemplateRepository implements IObjectRepository
{
    private $error="";
    private $TBL_DOCTEMPLATES="doctemplate";
    private $TBL_DOCTEMPLATE_FIELDS = "doctemplate_fields";
    private $TBL_USERGROUPSDOCTEMPLATES = "userGroups_docTemplates";
    
    public function __construct() {
    }

    function Save($obj)
    {
        $idList = "'-1'";
        /* @var $docTempl DocTemplate */
        $docTempl = $obj;
        
        if($docTempl)
        {
           $sqlCon = SqlHelper::StartTransaction();
           if(intval($docTempl->id) > 0)
           {
            $query = "UPDATE `".$this->TBL_DOCTEMPLATES."` 
                         SET `Name` = '".ToolsHelper::CleanInputString($docTempl->name)."' 
                         WHERE `Id` ='".intval($docTempl->id)."'";
            $rowNum = SqlHelper::ExecUpdateQuery($query,$sqlCon);
           }
           else
           {
            $query = "INSERT INTO `".$this->TBL_DOCTEMPLATES."`  (name) VALUES 
                ('".ToolsHelper::CleanInputString($docTempl->name)."')";
            $docTempl->id = intval(SqlHelper::ExecInsertQuery($query,$sqlCon));
            if (intval($docTempl->id) <= 0)
            {
                SqlHelper::RollbackTransaction($sqlCon);
                $this->error = "При добавлении/обновлении шаблона документа возникла ошибка!";
                return false;
            }
           }
           $tmpList[] = array();
           foreach($docTempl->lstobjFields as $field)
           {
               /* @var $field DocTemplateField */
               if(intval($field->id) > 0)
               {
                $query = "update ".$this->TBL_DOCTEMPLATE_FIELDS." set 
                              Name = '".ToolsHelper::CleanInputString($field->name)."', 
                              IsCalculated = '".intval($field->isCalculated)."',
                              FieldType = '".intval($field->fieldType)."',
                              IsRestricted = '".intval($field->isRestricted)."',
                              MinVal = '".$field->minVal."',
                              MaxVal = '".$field->maxVal."',
                              idDocTemplate = '". intval($docTempl->id)."'
                           where id = '".intval($field->id)."'";
                $rowNum = SqlHelper::ExecUpdateQuery($query,$sqlCon);
                if ($rowNum <= 0)
                {
                    SqlHelper::RollbackTransaction($sqlCon);
                    $this->error = "При изменении поля шаблона документа возникла ошибка!";
                    return false;
                }
                $idList=$idList.",'".$field->id."'";
               }
               else
               {
                $query = "INSERT INTO `".$this->TBL_DOCTEMPLATE_FIELDS."` ( `Name`, `IsCalculated`, `FieldType`, `IsRestricted`, `MinVal`, `MaxVal`, `IdDocTemplate`) 
                    VALUES ('".
                        ToolsHelper::CleanInputString($field->name)."','".
                        intval($field->isCalculated)."','".
                        intval($field->fieldType)."','".
                        intval($field->isRestricted)."','".
                        $field->minVal."','".
                        $field->maxVal."','".
                        $docTempl->id."')";
                $field->id = intval(SqlHelper::ExecInsertQuery($query,$sqlCon));
                if ($field->id <= 0)
                {
                    SqlHelper::RollbackTransaction($sqlCon);
                    $this->error = "При добавлении поля шаблона документа возникла ошибка!";
                    return false;
                }
                $tmpList[] = $field;
                //$docTempl->fieldsList[] = $field;
                $idList=$idList.",'".$field->id."'";
               }
                
           }
           $docTempl->lstobjFields = $tmpList;
           $query = "DELETE FROM `".$this->TBL_DOCTEMPLATE_FIELDS."` WHERE (`Id` NOT IN (".$idList.")) AND (`IdDocTemplate` = '".$docTempl->id."')";
                $rowNum = SqlHelper::ExecDeleteQuery($query,$sqlCon);
                if (is_null($rowNum))
                {
                    SqlHelper::RollbackTransaction($sqlCon);
                    $this->error = "При изменении полей шаблона документа возникла ошибка!";
                    return false;
                }
           SqlHelper::CommitTransaction($sqlCon);
           return true;
        }
        return false;
    }
    
    function Delete($obj)
    {
        /* @var $docTempl DocTemplate */
        $docTempl = $obj;
        
        if($docTempl && intval($docTempl->id) > 0)
        {
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
        /* @var $docTempl DocTemplate */
        $docTempl = new DocTemplate;
        
        $query = "SELECT Id,Name FROM `".$this->TBL_DOCTEMPLATES."` WHERE `Id`='".intval($id)."'";
        $row = SqlHelper::ExecSelectRowQuery($query);
        if($row)
        {
            $docTempl->id = $row['Id'];
            $docTempl->name = $row['Name'];
            $query = "SELECT Id, Name, IsCalculated, FieldType, IsRestricted, MaxVal, MinVal FROM `".$this->TBL_DOCTEMPLATE_FIELDS."` WHERE `IdDocTemplate`='".
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
                    $fld->fieldType = intval($row['FieldType']); 
                    $fld->isRestricted = (bool)$row['IsRestricted'];
                    $fld->maxVal = intval($row['MaxVal']);
                    $fld->minVal = intval($row['MinVal']);
                    $docTempl->lstobjFields[] = $fld;
                }
                //return $docTempl;
            }
//            else
//            {
//                $this->error = "При загрузке шаблонов полей возникла ошибка!";
//                return false;
//            }
            return $docTempl;
        }
        else
        {
            $this->error = "При загрузке шаблона документа возникла ошибка! id =".$id;
            return false;
        }
    }
    
    function GetDocTemplateFieldById($id)
    {
      $query = "SELECT Id, Name, IsCalculated, FieldType, IsRestricted, MaxVal, MinVal FROM `".$this->TBL_DOCTEMPLATE_FIELDS."` WHERE `IdDoctemplate`='".
                    intval($id)."'";
            $row = SqlHelper::ExecSelectCollectionQuery($query);
            if($row)
            {
                /* @var $fld DocTemplateField */
                $fld = new DocTemplateField;
                $fld->id = intval($row['Id']);
                $fld->name = $row['Name'];
                $fld->isCalculated = (bool)$row['IsCalculated'];
                $fld->fieldType = intval($row['FieldType']);
                $fld->isRestricted = (bool)$row['IsRestricted'];
                $fld->maxVal = intval($row['MaxVal']);
                $fld->minVal = intval($row['MinVal']);
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
        return true;
    }
    
   public function GetListByGroupID($id)
   {
       $res = Array();
       $query = "select idDocTemplate  from ".$this->TBL_USERGROUPSDOCTEMPLATES." where idGroup= '$id' ";
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
        $query = "select id,name from ".$this->TBL_DOCTEMPLATES;
                        
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
        $query = "select count(*) from ".$this->TBL_DOCTEMPLATES;
        
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
