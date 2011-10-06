<?php

/**
 * Description of DocTemplate
 *
 * @author Павел
 */
class DocTemplate {
    var $Id;
    var $Name;
    var $fieldsList;
    public function __construct($_name=null,$_id=null,$_fieldsList=null) {
        $this->Id = $_id;
        $this->Name = $_name;
        $this->fieldsList = $_fieldsList;
    }
}

?>
