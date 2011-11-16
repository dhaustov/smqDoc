<?php

/**
 * Description of DocTemplate
 *
 * @author Павел
 */
class DocTemplate {
    public $id;
    public $name;
    /* @var DocTemplateField[] */
    public $lstobjFields;
    
    public function __construct($_name=null,$_id=null,$_fieldsList=null) {
        $this->id = $_id;
        $this->name = $_name;
        $this->lstobjFields = $_fieldsList;
    }
    
}

?>
