<?php
/**
 * Description of DocTemplateField
 *
 * @author Павел
 */
class DocTemplateField {
    var $Id;
    var $Name;
    var $IsCalculated;
    /* @var $FieldType DocTemplateFieldType */
    var $FieldType;
    /* @var $IsRestricted boolen */
    var $IsRestricted;
    var $MinVal;
    var $MaxVal;
    /* @var $Operation DocTemplateOperation */
    var $Operation;
    
    public function __construct($_name=null,$_isCalculated=null,$_fieldType=null,
            $_isRestricted=null,$_minVal=null,$_maxVal=null,$_operation=null,$_id=null) {
        $this->Id = $_id;
        $this->Name = $_name;
        $this->IsCalculated = $_isCalculated;
        $this->FieldType = $_fieldType;
        $this->IsRestricted = $_isRestricted;
        $this->MinVal = $_minVal;
        $this->MaxVal = $_maxVal;
        $this->Operation = $_operation;
    }
}

?>
