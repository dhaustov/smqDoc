<?php

/**
 * Object from groups_docs table
 * Using repository UserGroupRepository for this class
 * @author Dmitry
 */
class UserGroup_DocTemplates 
{        
    public $id;
    public $name;
    public $idUserGroups;
    public $startDate;
    public $endDate;    
    public $idDocTemplate;
    public $status;   
    
    function __construct($_idUserGroups, $_idDocTemplate, $_name=null, 
                         $_startDate  = null, $_endDate = null, $_status = null,
                         $_id = null/*, $_docTemplateType = null*/)
    {
        $this->idUserGroups = $_idUserGroups;
        $this->idDocTemplate = $_idDocTemplate;
        $this->name = $_name;
        $this->startDate = $_startDate;
        $this->endDate = $_endDate;                
        $this->id = $_id;
        
        if($_status === null)
            $this->status = DbRecordStatus::ACTIVE;
        else
            $this->status = $_status;
    }
}

?>
