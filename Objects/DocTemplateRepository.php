<?php

/**
 * Description of DocTemplateRepository
 *
 * @author Павел
 */
class DocTemplateRepository implements IObjectRepository
{
    private $error;
    private $TBL_DOCTEMPLATES="doctemplates";
    private $TBL_DOCTEMPLATE_FIELDS = "doctemplate_fields";
    private $TBL_DOCTEMPLATE_FIELD_TYPES = "doctemplate_fieldtypes";
    private $TBL_DOCTEMPLATE_FIELD_OPERATIONS = "doctemplate_operations";
    
    
    function Save($obj)
    {
    
    }
    
    function Delete($obj)
    {
        /* @var $docTeml DocTemplate */
        $docTempl = $obj;
        if($docTempl)
        {
           
            $query = "DELETE FROM ".$this->TBL_DOCTEMPLATES." WHERE 'Id' =".intval($docTempl->Id);
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
