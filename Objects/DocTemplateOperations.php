<?php
/**
 * Description of DocTemplateOperations
 *
 * @author Павел
 */
class DocTemplateOperations {
    var $Id;
    var $Name;
    var $Code;
    public function __construct($_name=null,$_code=null,$_id=null) {
        $this->Id = $_id;
        $this->Name = $_name;
        $this->Code = $_code;
    }
}

?>
