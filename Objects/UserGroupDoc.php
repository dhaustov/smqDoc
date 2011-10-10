<?php


/**
 * Description of UserGroupDoc
 *
 * @author Павел
 */
class UserGroupDoc
{
    var $id;
    /* @var $author User*/
    var $author;
    /* @var $group UserGroup*/
    var $group;
    /* @var $groupDocTempl UserGroupDocTemplates*/
    var $groupDocTempl;
    var $status;
    var $dateCreated;
    var $lastChangedDate;
    var $fieldsList ;
    public function __construct($_id=null,$_author=null,$_groupDoc=null,$_status=null,
            $_dateCreated=null,$_lastChangedDate=null,$_fieldsList) {
        $this->id = $_id;
        $this->author = $_author;
        $this->group = $_group;
        $this->groupDocTempl = $_groupDoc;
        $this->status = $_status;
        $this->dateCreated = $_dateCreated;
        $this->lastChangedDate = $_lastChangedDate;
        $this->fieldsList = $_fieldsList;
        ;
    }
    public function ValidateObjectTypes()
    {
        if(!is_int($this->id))
            return false;
        if(!is_int($this->status))
            return false;
        if(!is_string($this->dateCreated))
            return false;
        if(!is_string($this->lastChangedDate))
            return false;
        if(!is_array($this->fieldsList))
                return false;
        foreach($this->fieldsList as $fld)
            if(!$fld->ValidateObjectTypes())
                return false;
        if(!is_subclass_of($this->author, 'User'))// || !$this->docTemplateField->ValidateObjectTypes())
                return false;
        if(!is_subclass_of($this->group, 'UserGroup') )//|| !$this->docTemplateField->ValidateObjectTypes())
                return false;
        if(!is_subclass_of($this->groupDocTempl, 'UserGroupDocTemplates'))// || !$this->docTemplateField->ValidateObjectTypes())
                return false;
        return true;
    }
}

?>
