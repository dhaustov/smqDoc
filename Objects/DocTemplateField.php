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
    var $maxVal;
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
        $this->maxVal = $_maxVal;
        $this->operation = $_operation;
    }
    
   public function ValidateObjectTypes()
   {
       if(!is_int($this->id))
            return false;
        if(!is_string($this->name))
            return false;
        if(!is_bool($this->isCalculated))
                return false;
        if(!is_subclass_of($this->fieldType, 'DocTemplateFieldType') || !$this->fieldType->ValidateObjectTypes())
                return false;
        if(!is_bool($this->isRestricted))
                return false;
        if(!is_subclass_of($this->operation, 'DocTemplateOperation') || !$this->operation->ValidateObjectTypes())
                return false;
        if($this->isRestricted && (!is_int($this->minVal) || !is_int($this->minVal)))
                return false;
        return true;
   }
}

?>
