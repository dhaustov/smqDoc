<?php


/**
 * Description of UserGroupDoc
 *
 * @author Павел
 */
class UserGroupDoc
{
    public $id;
    /* @var $author User*/
    public $author;//изменивший последним документ пользователь
    /* @var $group UserGroup*/
    public $group;//Группа владелец документа
    /* @var $objGroupDocTempl UserGroup_DocTemplates*/
    public $objGroupDocTempl;//Связь группы и шаблона   
    /* @var $objDocTemplate DocTemplate */
    public $objDocTemplate;
    public $status;
    public $dateCreated;
    public $lastChangedDate;
    //public $fieldsList ;
    
    /* @var $lstObjDocField UserGroupDocField */
    public $lstObjDocField;
    
    public function __construct($_lstObjDocField=null,$_id=null,$_author=null,$_groupDoc=null,$_status=null,
            $_dateCreated=null,$_lastChangedDate=null,$_group = null) {
        $this->id = $_id;
        $this->author = $_author;
        $this->group = $_group;
        $this->objGroupDocTempl = $_groupDoc;
        $this->status = $_status;
        $this->dateCreated = $_dateCreated;
        $this->lastChangedDate = $_lastChangedDate;
        //$this->fieldsList = $_fieldsList;
        $this->lstObjDocField = $_lstObjDocField;
    }
}

?>
