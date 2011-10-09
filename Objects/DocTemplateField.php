<?php
/**
 * Description of DocTemplateField
 *
 * @author Павел
 */
class DocTemplateField {
    var $id;
    var $name;
    var $isCalculated;
    /* @var $fieldType DocTemplateFieldType */
    var $fieldType;
    var $isRestricted;
    var $minVal;
    var $MaxVal;
    /* @var $operation DocTemplateOperation */
    var $operation;
    
    public function __construct($_name=null,$_isCalculated=null,$_fieldType=null,
            $_isRestricted=null,$_minVal=null,$_maxVal=null,$_operation=null,$_id=null) {
        $this->id = $_id;
        $this->name = $_name;
        $this->isCalculated = $_isCalculated;
        $this->fieldType = $_fieldType;
        $this->isRestricted = $_isRestricted;
        $this->minVal = $_minVal;
        $this->MaxVal = $_maxVal;
        $this->operation = $_operation;
    }
}

?>
