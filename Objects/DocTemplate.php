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
}

?>
