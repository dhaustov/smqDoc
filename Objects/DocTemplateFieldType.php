<?php


/**
 * Description of DocTemplateFieldType
 *
 * @author Павел
 */
class DocTemplateFieldType {
    var $Id;
    var $Name;
    var $DataBaseType;
    public function __construct($_name=null,$_databasetype=null,$_id=null) {
        $this->Id = $_id;
        $this->Name = $_name;
        $this->DataBaseType = $_databasetype;
    }
}

?>
