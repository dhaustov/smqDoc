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
    
    public function  PerformAction($_command)
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
                
                /*новая группа*/
                /* @var $tmpGroup UserGroup  */
                $tmpGroup = new UserGroup( $_POST["selIdMasterUser"],
                                       $_POST["lblName"],
                                       $_POST["lblMasterUserRole"],
                                       $_POST["selIdParentGroup"],
                                       $_POST["selStatus"],
                                       $_POST["hdnGid"]
                                     );                
                    
                //Собираем новые темплейты    
                $newTpls = Array(); 
                $cntNewFields = 0;
                $cntOldFields = 0;
                
                if(isset($_POST['hdnNewTempCount']))
                    $cntNewFields = $_POST['hdnNewTempCount']; //общее количество полей на форме
                echo "cntnew".$cntNewFields;
                
                $i=1;                 
                while($i<=$cntNewFields)
                {
                    if(isset($_POST['hdnNewTemplate'.$i]))
                    {    
                        //$newFields[] = $_POST['hdnNewTemplate'.$cnt];                          
                        $newTpls[] = new UserGroup_DocTemplates($_POST["hdnGid"], $_POST['hdnNewTemplate'.$i],
                                                                $_POST['newTemplateName'.$i], $_POST['newTemplateStart'.$i],
                                                                $_POST['newTemplateEnd'.$i]);                                                                        
                    }                        
                    $i++;                  
                }
                
                //Собираем старые темплейты
                if(isset($_POST['hdnOldTempCount']))
                    $cntOldFields = $_POST['hdnOldTempCount']; 
                
                for($i=1; $i<=$cntOldFields; $i++)
                {
                    if(isset($_POST['hdnOldTemplate'.$i]))
                    {                            
                        $newTpls[] = new UserGroup_DocTemplates($_POST["hdnGid"], $_POST['hdnOldTemplate'.$i],
                                                                $_POST['oldTemplateName'.$i], $_POST['oldTemplateStart'.$i],
                                                                $_POST['oldTemplateEnd'.$i], null,$_POST['hdnOldTemplateID'.$i] );                                                
                    }                                            
                }
                                             
                if( count($newTpls) > 0 )                                   
                    $tmpGroup->AddRelatedDocTemplates($newTpls);                                
                
                if(!$validator->IsValid($tmpGroup)) //валидируем
                {
                    $this->error = $validator->GetError();
                    return false;
                }
                $this->group = $tmpGroup;                
                if($this->repository->Save($this->group))
                   $res = $this->group;                     
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
        {
            echo "resName = ".$res->name;
            return $res; 
        }
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
    
    public function GetDocTemplatesExistsList()
    {
        if(isset($this->group)&& $this->group->id > 0)
        {
            //$rep = new DocTemplateRepository();
            //return $rep->GetListByGroupID($this->group->id);
            $rep = new UserGroup_DocTemplatesRepository();
            return $rep->GetListByUserGroupId($this->group->id);
            
        }
        return false;
    }
    
    public function GetDocTemplatesAllList()
    {
        $rep = new DocTemplateRepository();        
        $res = $rep->GetList();        
//         $rep = new UserGroup_DocTemplatesRepository();
//         $res = $rep->GetList();
        return $res;
    }
    
    public function GetError()
    {
        return $this->error;
    }        
}

?>
