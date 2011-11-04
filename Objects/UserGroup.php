<?php

/**
 * User Groups. Related with table user_groups
 *
 * @author Dmitry G. Haustov
 */
class UserGroup {
    public $id;
    public $name;
    public $idParentGroup;
    public $idMasterUserAccount;
    public $masterUserAccountRole;
    public $status;
    
    private $relatedDocumentTemplates;
    
    function __construct( $_idMasterUserAccount=null, $_name = null, $_masterUserAccountRole = null, 
                          $_idParentGroup = null, $_status = null, $_id = null) 
    {
        $this->idMasterUserAccount = $_idMasterUserAccount;
        $this->name = $_name;
        $this->idParentGroup = $_idParentGroup;
        $this->masterUserAccountRole = $_masterUserAccountRole;
        $this->id = $_id;       
        if($_status === null)
            $this->status = DbRecordStatus::ACTIVE;
        else
            $this->status = $_status;
    }
    
    public function AddRelatedDocTemplates($docs)
    {
        $this->relatedDocumentTemplates = $docs;    
    }
    
    public function GetRelatedDocTemplates()
    {
        if(count($this->relatedDocumentTemplates)>0) 
            return $this->relatedDocumentTemplates;
        else
            return false;
            
    }
}

?>
