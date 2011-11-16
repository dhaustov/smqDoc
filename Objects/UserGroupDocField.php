<?php

/**
 * Description of UserGroupDocFiled
 *
 * @author Павел
 */
class UserGroupDocField {
    public $id;
    /* @var $docTemplateField DocTemplateField  */
    public $docTemplateField;
    public $stringValue;
    public $intValue;
    public $boolValue;
    
    public function __construct($_docTemplateField=null,$_stringValue=null,$_intValue=null,$_boolValue=null,$_id=null)
    {
        $this->id = $_id;
        $this->docTemplateField = $_docTemplateField;
        $this->stringValue = $_stringValue;
        $this->intValue = $_intValue;
        $this->boolValue = $_boolValue;
    }
    
    
    public function GetValue()
    {
        if($this->docTemplateField)
        {
            if($this->docTemplateField->fieldType == EnDocTemplateFieldTypes::BOOL)
                return $this->boolValue;
            if($this->docTemplateField->fieldType == EnDocTemplateFieldTypes::INT)
                return $this->intValue;
            if($this->docTemplateField->fieldType == EnDocTemplateFieldTypes::STRING)
                return $this->stringValue;
        }
        return false;
    }
    public function SetValue($_val)
    {
        if($this->docTemplateField)
        {
            $this->boolValue = null;
            $this->intValue = null;
            $this->stringValue = null;
            if($this->docTemplateField->fieldType == EnDocTemplateFieldTypes::BOOL)
                $this->boolValue = _val;
            if($this->docTemplateField->fieldType == EnDocTemplateFieldTypes::INT)
                $this->intValue = _val;
            if($this->docTemplateField->fieldType == EnDocTemplateFieldTypes::STRING)
                $this->stringValue = _val;
        }
        return false;
    }

}

?>
