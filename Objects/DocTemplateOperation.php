<?php
/**
 * Description of DocTemplateOperation
 *
 * @author Павел
 */
class DocTemplateOperation {
    var $id;
    var $name;
    var $code;
    public function __construct($_name=null,$_code=null,$_id=null) {
        $this->id = $_id;
        $this->name = $_name;
        $this->code = $_code;
    }
}

?>
