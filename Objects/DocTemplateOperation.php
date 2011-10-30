<?php
/**
 * Description of DocTemplateOperation
 *
 * @author Павел
 */
class DocTemplateOperation {
    public $id;
    public $name;
    public $code;
    
    public function __construct($_name=null,$_code=null,$_id=null) {
        $this->id = $_id;
        $this->name = $_name;
        $this->code = $_code;
    }
    
    public function ValidateObjectTypes()
    {
        if(!is_int($this->id))
            return false;
        if(!is_string($this->name))
            return false;
        if(!is_string($this->code))
            return false;
        return true;
    }
}

?>
