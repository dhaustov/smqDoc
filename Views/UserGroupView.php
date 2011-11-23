<?php

/**
 * Description of UserGroupView
 *
 * @author Dmitry
 */
class UserGroupView  implements IView
{
    const TPL_CREATEEDIT = '/templates/UserGroup/userGroupCreateEdit.php';    
    const TPL_SHOW = '/templates/UserGroup/userGroupInfo.php';
    const TPL_SHOWLIST = '/templates/UserGroup/userGroupList.php';
    const TPL_SUCCESS = '/templates/UserGroup/userGroupSuccess.php';
    const TPL_ERROR = '/templates/ErrorPage.php';
    
    private $command;    
    private $res;
    private $error = "";
    
    public $totalItems;
    public $userAccounts;
    public $otherGroups;
    public $frmAction;
    public $masterUser;
    public $parentGroup;
 
    public $lstGroupMasterUsers;
    public $lstGroupParents;
    
    public $lstDocTemplatesAll;    
    public $lstDocTemplatesExists;
           
    public $currentTemplate;
    
    function __construct(UserGroupCommand $_command = null)
    {
        $this->command = $_command;    
    }
    
    public function SetResult($_res=null, $_error = null)
    {
        $this->res = $_res;
        $this->error = $_error;
        
        switch($this->command->action)
        {
            
            case Actions::SAVE :
                if($this->error != null)
                {                    
                    $this->res =  new UserGroup( $_REQUEST["selIdMasterUser"],
                                           $_REQUEST["lblName"],
                                           $_REQUEST["lblMasterUserRole"],
                                           $_REQUEST["selIdParentGroup"],
                                           $_REQUEST["selStatus"],
                                           $_REQUEST["hdnGid"]
                                         );
                    
                    $newTpls = Array(); 
                    $cntNewFields = 0;
                    $cntOldFields = 0;
                    
                    if(isset($_POST['hdnNewTempCount']))
                        $cntNewFields = $_POST['hdnNewTempCount']; //общее количество полей на форме                    
                    
                    $i=1;                     
                    while($i<$cntNewFields)
                    {
                        if(isset($_POST['hdnNewTemplate'.$i]))
                        {                                
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
                                                                    $_POST['oldTemplateEnd'.$i], null,$_POST['hdnOldTemplateID'.$i]);                                                
                        }                                            
                    }
                
                    $this->res->AddRelatedDocTemplates($newTpls);
                    
                    $this->currentTemplate = UserGroupView::TPL_CREATEEDIT;
                    $this->frmAction = "index.php?module=".Modules::USERGROUPS."&action=".Actions::SAVE;
                }
                else
                {
                    $outText = "Группа ". $this->res->name." сохранена успешно! ";                                       
                    $this->res = $outText;
                    $this->currentTemplate = UserGroupView::TPL_SUCCESS;                    
                } 
                break;
            case Actions::CREATE :                
                $this->res = new UserGroup();
                $this->currentTemplate = UserGroupView::TPL_CREATEEDIT;                                    
                $this->frmAction = "index.php?module=".Modules::USERGROUPS."&action=".Actions::SAVE;
            break;   
            
            case Actions::SHOW :
                if($this->error != null)                                      
                    $this->currentTemplate = UserGroupView::TPL_ERROR;                                    
                else                
                    $this->currentTemplate = UserGroupView::TPL_SHOW;                                     
                break;
            
            case Actions::EDIT :   //почти то же, что и create
                if($this->error != null)                
                {           
                    $this->currentTemplate = UserGroupView::TPL_ERROR;                    
                }
                else
                {   
                    $this->currentTemplate = UserGroupView::TPL_CREATEEDIT;
                    $this->frmAction = "index.php?module=".Modules::USERGROUPS."&action=".Actions::SAVE;
                }
            break;
            
            case Actions::SHOWLIST :                
                $this->currentTemplate = UserGroupView::TPL_SHOWLIST;                
                $this->frmAction = "index.php?module=".Modules::USERGROUPS."&action=".Actions::SHOWLIST;
            break;
        }
    }
    
    public function ShowPage()
    {
        //Переменные для вывода в шаблоне
        $res = $this->res;
        $error = $this->error;
        $frmAction = $this->frmAction;        
        $userAccounts = $this->userAccounts;
        $otherGroups = $this->otherGroups;
        $masterUser = $this->masterUser;
        $parentGroup = $this->parentGroup;
        $totalItems = $this->totalItems;
        $lstGroupMasterUsers  = $this->lstGroupMasterUsers;
        $lstGroupParents = $this->lstGroupParents;
        $lstDocTemplatesAll = $this->lstDocTemplatesAll;
        $lstDocTemplatesExists = $this->lstDocTemplatesExists;
        
        include_once $this->currentTemplate;    
    }
    
    
    public function ShowErrorPage()
    {
        echo "Error page: ".$this->error;
    }
    
    public function GetMenuItems()
    {                
        $url = "index.php?module=".Modules::USERGROUPS."&action=".Actions::SHOWLIST;
        $text = "Группы и роли";
        $active = $this->command->action == Actions::SHOWLIST ? true : false;
                        
        $url1 = "index.php?module=".Modules::USERGROUPS."&action=".Actions::CREATE;
        $text1 = "Создать группу";
        $active1 = $this->command->action == Actions::CREATE ? true : false;
                
        $res = Array( new TemplateMenuItem($text, $url, $active),
                      new TemplateMenuItem($text1, $url1, $active1) );
        return $res;
    }
}

?>
