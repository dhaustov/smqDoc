<?php

/**
 * Description of UserGroupDocFiled
 *
 * @author Павел
 */
class UserGroupDocField {
    var $id;
    /* @var $docTemplateField DocTemplateField */
    var $docTemplateField;
    var $stringValue;
    var $intValue;
    var $boolValue;
    public function __construct($_id=null,$_docTemplateField=null,$_stringValue=null,$_intValue=null,$_boolValue=null)
    {
        $this->id = $_id;
        $this->docTemplateField = $_docTemplateField;
        $this->stringValue = $_stringValue;
        $this->intValue = $_intValue;
        $this->boolValue = $_boolValue;
    }
    public function ValidateObjectTypes()
    {
        if(!is_int($this->id))
            return false;
        if(!is_string($this->stringValue))
            return false;
        if(!is_int($this->intValue))
            return false;
        if(!is_bool($this->boolValue))
            return false;
        if(!is_subclass_of($this->docTemplateField, 'DocTemplateField') || !$this->docTemplateField->ValidateObjectTypes())
                return false;
        return true;
    }
}

?>
