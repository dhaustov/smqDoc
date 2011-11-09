<?php
/**
 * Description of UserGroupDocView
 *
 * @author Dmitry
 */
class UserGroupDocView implements IView
{
    const TPL_CREATEEDIT = '/templates/UserGroupDoc/userGroupDocCreateEdit.php';    
    const TPL_SHOW = '/templates/UserGroupDoc/userGroupDocInfo.php';
    const TPL_SHOWLIST = '/templates/UserGroupDoc/userGroupDocList.php';
    const TPL_SUCCESS = '/templates/UserGroupDoc/userGroupDocSuccess.php';
    const TPL_ERROR = '/templates/ErrorPage.php';
    
    private $command;    
    private $res;
    private $error = "";
    
    public $totalItems;
    public $allowedTemplates;
//    public $userAccounts;
//    public $otherGroups;
    public $frmAction;
//    public $masterUser;
//    public $parentGroup;
// 
//    public $lstGroupMasterUsers;
//    public $lstGroupParents;
//    
//    public $lstDocTemplatesAll;    
//    public $lstDocTemplatesExists;
           
    public $currentTemplate;
    
    function __construct(UserGroupDocCommand $_command = null)
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
                
                    $this->res = $doc;
                    
//                    $this->res =  new UserGroup( $_REQUEST["selIdMasterUser"],
//                                           $_REQUEST["lblName"],
//                                           $_REQUEST["lblMasterUserRole"],
//                                           $_REQUEST["selIdParentGroup"],
//                                           $_REQUEST["selStatus"],
//                                           $_REQUEST["hdnGid"]
//                                         );
                    $this->currentTemplate = UserGroupDocView::TPL_CREATEEDIT;
                    $this->frmAction = "index.php?module=".Modules::DOCUMENTS."&action=".Actions::SAVE;
                }
                else
                {
                    $outText = "Документ сохранён успешно! ";                                       
                    $this->res = $outText;
                    $this->currentTemplate = UserGroupDocView::TPL_SUCCESS;                    
                } 
                break;
            case Actions::CREATE :                             
                $this->currentTemplate = UserGroupDocView::TPL_CREATEEDIT;                                    
                if(!isset($_POST['selTid']))
                    $this->frmAction = "index.php?module=".Modules::DOCUMENTS."&action=".Actions::CREATE;
                else                    
                    $this->frmAction = "index.php?module=".Modules::DOCUMENTS."&action=".Actions::SAVE;
            break;   
            
            case Actions::SHOW :
                if($this->error != null)                
                {           
                    $this->currentTemplate = UserGroupDocView::TPL_ERROR;                    
                }
                else
                {   
                    $this->currentTemplate = UserGroupDocView::TPL_SHOW;                     
                }
                break;
            
            case Actions::EDIT :   //почти то же, что и create
                if($this->error != null)                
                {           
                    $this->currentTemplate = UserGroupDocView::TPL_ERROR;                    
                }
                else
                {   
                    $this->currentTemplate = UserGroupDocView::TPL_CREATEEDIT;
                    $this->frmAction = "index.php?module=".Modules::DOCUMENTS."&action=".Actions::SAVE;
                }
            break;
            
            case Actions::SHOWLIST :                
                $this->currentTemplate = UserGroupDocView::TPL_SHOWLIST;                
                $this->frmAction = "index.php?module=".Modules::DOCUMENTS."&action=".Actions::SHOWLIST;
            break;
        }
    }
    
    public function ShowPage()
    {
        //Переменные для вывода в шаблоне
        $res = $this->res;
        $error = $this->error;
        $frmAction = $this->frmAction;        

        $totalItems = $this->totalItems;
        $allowedTemplates = $this->allowedTemplates;
        
        include_once $this->currentTemplate;    
    }
    
    
    public function ShowErrorPage()
    {
        echo "Error page: ".$this->error;
    }
    
    public function GetMenuItems()
    {                
        $url = "index.php?module=".Modules::DOCUMENTS."&action=".Actions::SHOWLIST;
        $text = "Сохранённые документы";
        $active = $this->command->action == Actions::SHOWLIST ? true : false;
                        
        $url1 = "index.php?module=".Modules::DOCUMENTS."&action=".Actions::CREATE;
        $text1 = "Создать документ";
        $active1 = $this->command->action == Actions::CREATE ? true : false;
                
        $res = Array( new TemplateMenuItem($text, $url, $active),
                      new TemplateMenuItem($text1, $url1, $active1) );
        return $res;
    }
}

?>
