<?php


/**
 * Description of UserGroupDocument
 *
 * @author Павел
 */
class UserGroupDocument {
    var $Id;
    /* @var $Author User*/
    var $Author;
//    /* @var $Group UserGroup*/
//    var $Group;
    /* @var $GroupDoc UserGroupDocTemplates*/
    var $GroupDoc;
    var $Status;
    var $DateCreated;
    var $LastChangedDate;
    var $fieldsList ;
    public function __construct($_id=null,$_author=null,$_groupDoc=null,$_status=null,
            $_dateCreated=null,$_lastChangedDate=null,$_fieldsList) {
        $this->Id = $_id;
        $this->Author = $_author;
        $this->Group = $_group;
        $this->GroupDoc = $_groupDoc;
        $this->Status = $_status;
        $this->DateCreated = $_dateCreated;
        $this->LastChangedDate = $_lastChangedDate;
        $this->fieldsList = $_fieldsList;
        ;
    }
    
}

?>
