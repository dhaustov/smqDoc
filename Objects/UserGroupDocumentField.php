<?php

/**
 * Description of UserGroupDocumentFiled
 *
 * @author Павел
 */
class UserGroupDocumentField {
    var $Id;
    var $DocTemplateField;
    var $StringValue;
    var $IntValue;
    var $BoolValue;
    public function __construct($_id=null,$_docTemplateField=null,$_stringValue=null,$_intValue=null,$_boolValue=null)
    {
        $this->Id = $_id;
        $this->DocTemplateField = $_docTemplateField;
        $this->StringValue = $_stringValue;
        $this->IntValue = $_intValue;
        $this->BoolValue = $_boolValue;
    }
}

?>
