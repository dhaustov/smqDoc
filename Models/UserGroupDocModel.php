<?php
/**
 * Description of UserGroupDocModel
 *
 * @author Павел
 */
class UserGroupDocModel implements IModel
{
    /* @var $currentCommand UserGroupDocCommand */
    private $currentCommand; 
    /* @var $doc UserGroupDoc */
    private $doc;
    /* @var $repository UserGroupDocRepository */
    private $repository;
    private $error;
    
    public function __construct()
    {
        $this->repository = new UserGroupDocRepository();
    }
    
    public function PerformAction($_command)
    {        
        $this->currentCommand = $_command;
                
        $res = false;
        switch($this->currentCommand->action)
        {            
            case Actions::CREATE :
                
                if(isset($_POST['selTid'])) //если перешли с формы выбора шаблона
                {
                    $res = new UserGroupDoc();
                    
                    $tplRep = new DocTemplateRepository;
                    $tpl = $tplRep->GetByID($_POST['selTid']);
                    if($tpl)
                    {                        
                        $res->groupDocTempl = $tpl;
                        foreach ($tpl->fieldsList as $field)
                        {
                            //$_docTemplateField=null,$_stringValue=null,$_intValue=null,$_boolValue=null,$_id=null
                            $res->fieldsList[] = new UserGroupDocField($field);
                        }
                    }
                    
                    $ug = LoginHelper::GetCurrentUserGroup();
                    $res->group = $ug;                    
                    $res->author = LoginHelper::GetCurrentUser();                    
                    
                    $this->res = $res;                    
                }
                break;
            case Actions::DELETE :
                $res = $this->repository->Delete($this->doc);                                                  
                break;
            case Actions::SAVE : 
                
                $tid = $_POST['hdnTid'];
                
                $doc = new UserGroupDoc();
                    
                $tplRep = new DocTemplateRepository;
                $tpl = $tplRep->GetByID($tid);
                if($tpl)
                {                                   
                    $doc->groupDocTempl = $tpl;
                    $i=0;
                    foreach ($tpl->fieldsList as $field)
                    {
                        //TODO: пока пишется только строка
                        $doc->fieldsList[] = new UserGroupDocField($field, $_POST["txtVal$i"]);                        
                        $i++;
                    }
                }
                
                $ug = LoginHelper::GetCurrentUserGroup();
                $doc->group = $ug;                    
                $doc->author = LoginHelper::GetCurrentUser();                    
                
                $dID = $this->repository->Save($doc);
                
                if($dID)
                    $res = $this->repository->GetByID ($dID);                

                break;                
            case Actions::EDIT :
            case Actions::SHOW :
                $this->doc = $this->repository->GetById($this->currentCommand->id);
                if($this->doc)
                    $res = $this->doc;
                break;
            case Actions::SHOWLIST :
                $pageSize = 0;
                $pageNum = 0;
                if(isset($_REQUEST["pageSize"]))
                    $pageSize = (int)$_REQUEST["pageSize"];
                if(isset($_REQUEST["pageNum"]))
                    $pageNum = (int)$_REQUEST["pageNum"];
                
                $res = $this->repository->GetList($pageSize,$pageNum);
                break;                
            default:
                //этого не может быть!
                break;
        }    
        
        if($res)
            return $res; 
        else
        {
            $this->error = $this->repository->GetError();
            return false;        
        }
    }
    
    public function GetFieldTypesList()
    {
        return $this->repository->docTemplateFieldTypesArr;
    }
    
    public function GetOperationsList()
    {
        return $this->repository->docTemplateOperationsArr;
    }
        
    public function GetListItemsCount()
    {
        return $this->repository->GetListItemsCount();
    }
    
    public function GetError()
    {
        return $this->error;
    }
}

?>
