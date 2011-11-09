<?php

/**
 * Description of UserGroupDocFiled
 *
 * @author Павел
 */
class UserGroupDocField {
    public $id;
    /* @var $docTemplateField DocTemplateField */
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
        if($this->stringValue != "")
            return $this->stringValue;
        if($this->intValue > 0)
            return $this->intValue;
        if($this->boolValue)
            return true;
        
        return false;
    }
//    public function ValidateObjectTypes()
//    {
//        if(!is_int($this->id))
//            return false;
//        if(!is_string($this->stringValue))
//            return false;
//        if(!is_int($this->intValue))
//            return false;
//        if(!is_bool($this->boolValue))
//            return false;
//        if(!is_subclass_of($this->docTemplateField, 'DocTemplateField') || !$this->docTemplateField->ValidateObjectTypes())
//                return false;
//        return true;
//    }
}

?>
