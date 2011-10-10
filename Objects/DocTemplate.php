<?php

/**
 * Description of DocTemplate
 *
 * @author Павел
 */
class DocTemplate {
    var $id;
    var $name;
    var $fieldsList;
    public function __construct($_name=null,$_id=null,$_fieldsList=null) {
        $this->id = $_id;
        $this->name = $_name;
        $this->fieldsList = $_fieldsList;
    }
    
    public function ValidateObjectTypes()
    {
        if(!is_int($this->id))
            return false;
        if(!is_string($this->name))
            return false;
        if(!is_array($this->fieldsList))
            return false;
        foreach($this->fieldsList as $fld)
            if(!$fld->ValidateObjectTypes())
                return false;
        return true;
    }
}

?>
