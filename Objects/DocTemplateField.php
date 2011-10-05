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
    var $FieldType;
    var $IsRestricted;
    var $MinVal;
    var $MaxVal;
    var $Operation;
    
    public function __construct($_name=null,$_isCalculated=null,$_fieldType,
            $_isRestricted,$_minVal,$_maxVal,$_operation,$_id=null) {
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
