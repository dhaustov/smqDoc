<?php


/**
 * Description of DocTemplateFieldType
 *
 * @author Павел
 */
class DocTemplateFieldType {
    public $id;
    public $name;
    public $dataBaseType;
    
    public function __construct($_name=null,$_databasetype=null,$_id=null) {
        $this->id = $_id;
        $this->name = $_name;
        $this->dataBaseType = $_databasetype;
    }
//    public function ValidateObjectTypes()
//    {
////        if(!is_int($this->id))
////            return false;
//        if(!is_string($this->name))
//            return false;
//        if(!is_string($this->dataBaseType))
//            return false;
//        return true;
//    }
}

?>
