<?php
/**
 * Description of DocTemplateField
 *
 * @author Павел
 */
class DocTemplateField {
    public $id;
    public $name;
    public $isCalculated;
    public $fieldType;
    public $isRestricted;
    public $minVal;
    public $maxVal;
    
    public function __construct($_name=null,$_isCalculated=null,$_fieldType=null,
            $_isRestricted=null,$_minVal=null,$_maxVal=null,$_operation=null,$_id=null) {
        $this->id = $_id;
        $this->name = $_name;
        $this->isCalculated = $_isCalculated;
        $this->fieldType = $_fieldType;
        $this->isRestricted = $_isRestricted;
        $this->minVal = $_minVal;
        $this->maxVal = $_maxVal;
    }
}

?>
