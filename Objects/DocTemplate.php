<?php

/**
 * Description of DocTemplate
 *
 * @author Павел
 */
class DocTemplate {
    var $Id;
    var $Name;
    public function __construct($_name=null,$_id=null) {
        $this->Id = $_id;
        $this->Name = $_name;
    }
}

?>
