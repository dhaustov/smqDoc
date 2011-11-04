<?php
/**
 * Description of UserGroupModel
 *
 * @author Dmitry
 */
class UserGroupModel implements IModel
{
       /* @var $currentCommand UserGroupCommand */
    private $currentCommand; 
    /* @var $group UserGroup */
    private $group;
    /* @var $repository UserGroupRepository */
    private $repository;
    private $error;
    
    public function __construct()
    {
        $this->repository = new UserGroupRepository();
    }
    
    public function PerformAction($_command)
    {        
        $this->currentCommand = $_command;
                
        $res = false;
        switch($this->currentCommand->action)
        {            
            case Actions::CREATE :
                $res = new UserGroup();                
                break;
            case Actions::DELETE :
                $res = $this->repository->Delete($this->group);                                                                               
                break;
            case Actions::SAVE :              
                $validator = new UserGroupValidator();
                
                $tmpGroup = new UserGroup( $_POST["selIdMasterUser"],
                                           $_POST["lblName"],
                                           $_POST["lblMasterUserRole"],
                                           $_POST["selIdParentGroup"],
                                           $_POST["selStatus"],
                                           $_POST["hdnGid"]
                                         );
                if(!$validator->IsValid($tmpGroup)) //валидируем
                {
                    $this->error = $validator->GetError();
                    return false;
                }
                $this->group = $tmpGroup;                
                $gid = $this->repository->Save($this->group);
                
                if($gid)                
                    $res = $this->repository->GetById($gid);                
                break;
            
            case Actions::EDIT :
            case Actions::SHOW :
                $this->group = $this->repository->GetById($this->currentCommand->id);
                if($this->group)
                    $res = $this->group;
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
    
    public function GetUserList()
    {
        $rep = new UserRepository();
        $res = $rep->GetList();
        return $res;
    }
    
    public function GetMasterUser($id)
    {
        $rep = new UserRepository();
        return $rep->GetById($id);
    }
    
    public function GetParentGroup($id)
    {
        return $this->repository->GetById($id);
    }
    
    public function GetOtherGroupsList()
    {
        return $this->repository->GetList();
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
