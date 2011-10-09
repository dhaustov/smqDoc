<?php


/**
 * Description of DocTemplateFieldType
 *
 * @author Павел
 */
class DocTemplateFieldType {
    var $id;
    var $name;
    var $dataBaseType;
    public function __construct($_name=null,$_databasetype=null,$_id=null) {
        $this->id = $_id;
        $this->name = $_name;
        $this->dataBaseType = $_databasetype;
    }
}

?>
