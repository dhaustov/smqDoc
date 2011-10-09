<?php

/**
 * Description of UserGroupDocFiled
 *
 * @author Павел
 */
class UserGroupDocField {
    var $id;
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
}

?>
