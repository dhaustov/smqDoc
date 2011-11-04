<?php
/**
 * Description of testView
 *
 * @author Dmitry
 */
class UserView implements IView
{       
    const TPL_CREATEEDIT = '/templates/UserAccount/userCreateEdit.php';    
    const TPL_SHOW = '/templates/UserAccount/userInfo.php';
    const TPL_SHOWLIST = '/templates/UserAccount/userList.php';
    const TPL_SUCCESS = '/templates/UserAccount/userSuccess.php';
    const TPL_ERROR = '/templates/ErrorPage.php';
    
    private $command;    
    private $res;
    private $error;
    
    public $totalItems;
    private $frmAction;
    
    private $currentTemplate;
    
    function __construct(UserCommand $_command = null)
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
                    $this->res = new UserAccount(  $_REQUEST["lblLogin"],
                                             "",
                                             $_REQUEST["lblName"],                     
                                             $_REQUEST["lblSurname"],                                             
                                             $_REQUEST["lblMiddlename"],
                                             $_REQUEST["status"]);
                                        
                    $this->currentTemplate = UserGroupView::TPL_CREATEEDIT;
                    $this->frmAction = "index.php?module=".Modules::USERS."&action=".Actions::SAVE;
                }
                else
                {
                    $outText = "Пользователь ". $this->res->login." сохранён успешно! ";                                       
                    $this->currentTemplate = UserView::TPL_SUCCESS;
                    $this->res = $outText;          
                } 
                break;
            case Actions::CREATE :                
                $this->res = new UserAccount;
                $this->currentTemplate = UserView::TPL_CREATEEDIT;
                $this->frmAction = "index.php?module=".Modules::USERS."&action=".Actions::SAVE;                
            break;   
            
            case Actions::SHOW :
                if($this->error != null)                
                {                    
                    $this->currentTemplate = UserView::TPL_ERROR;                    
                }
                else
                {                    
                    $this->currentTemplate = UserView::TPL_SHOW;
                }
                break;
            
            case Actions::EDIT :   //почти то же, что и create
                if($this->error != null)                
                {           
                    $this->currentTemplate = UserView::TPL_ERROR;                    
                }
                else
                {   
                    $this->currentTemplate = UserView::TPL_CREATEEDIT;
                    $this->frmAction = "index.php?module=".Modules::USERS."&action=".Actions::SAVE;
                }                
            break;
            
            case Actions::SHOWLIST :                
                $this->currentTemplate = UserView::TPL_SHOWLIST;                
                $this->frmAction = "index.php?module=".Modules::USERS."&action=".Actions::SHOWLIST;
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
        
        include_once $this->currentTemplate;    
    }
    
    /*
    public function ShowPage($_res = null, $_error = null)
    {
        $this->res = $_res;
        $this->error = $_error;
        
        $mainLayoutTemplate = new MainLayoutView();
        $mainLayoutTemplate->title = "Система менеджмента качества";               
        $mainLayoutTemplate->header = new TemplateHeaderItem("Управление учётными записями пользователей");                
        $mainLayoutTemplate->footer = new TemplateFooterItem( __CLASS__ );                                
        $mainLayoutTemplate->menu = $this->GetMenuItems();
        
        switch($this->command->action)
        {
            
            case Actions::SAVE :
                if($this->error != null)
                {
                    $this->res = new UserAccount(  $_REQUEST["lblLogin"],
                                             "",
                                             $_REQUEST["lblName"],                     
                                             $_REQUEST["lblSurname"],                                             
                                             $_REQUEST["lblMiddlename"],
                                             $_REQUEST["status"]);
                                        
                    $mainLayoutTemplate->SetContentTemplate(UserView::TPL_CREATEEDIT);
                    $mainLayoutTemplate->ShowPage($this->res, $this->error, "index.php?module=".Modules::USERS."&action=".Actions::SAVE);                
                }
                else
                {
                    $outText = "Пользователь ". $this->res->login." сохранён успешно! ";                                       
                    $mainLayoutTemplate->SetContentTemplate(UserView::TPL_SUCCESS);
                    $mainLayoutTemplate->ShowPage($outText);                
                } 
                break;
            case Actions::CREATE :                
                $this->res = new UserAccount;
                                
                $mainLayoutTemplate->SetContentTemplate(UserView::TPL_CREATEEDIT);
                $mainLayoutTemplate->ShowPage($this->res, $this->error, "index.php?module=".Modules::USERS."&action=".Actions::SAVE);                
            break;   
            
            case Actions::SHOW :
                if($this->error != null)                
                {                    
                    $mainLayoutTemplate->SetContentTemplate(UserView::TPL_ERROR);
                    $mainLayoutTemplate->ShowPage($this->res, $this->error);                
                }
                else
                {                    
                    $mainLayoutTemplate->SetContentTemplate(UserView::TPL_SHOW);
                    $mainLayoutTemplate->ShowPage($this->res, $this->error);                
                }
                break;
            
            case Actions::EDIT :   //почти то же, что и create
                $mainLayoutTemplate->SetContentTemplate(UserView::TPL_CREATEEDIT);
                $mainLayoutTemplate->ShowPage($this->res, $this->error, "index.php?module=".Modules::USERS."&action=".Actions::SAVE);                                
            break;
            
            case Actions::SHOWLIST :                
                $mainLayoutTemplate->SetContentTemplate(UserView::TPL_SHOWLIST);
                $mainLayoutTemplate->ShowPage($this->res, $this->error,  "index.php?module=".Modules::USERS."&action=".Actions::SHOWLIST);                
            break;
        }
                
    }
    */
    /*
    public function GetParams($_res  = null, $_error = null)
    {
        $this->output = $_res;
        $this->error = $_error;
        
        switch($this->command->action)
        {
            
            case Actions::SAVE :
                if($this->error != null)
                {
                    $this->output = new UserAccount(  $_REQUEST["lblLogin"],
                                             "",
                                             $_REQUEST["lblName"],                     
                                             $_REQUEST["lblSurname"],                                             
                                             $_REQUEST["lblMiddlename"],
                                             $_REQUEST["status"]);
                    
                    $this->frmAction = "index.php?module=".Modules::USERS."&action=".Actions::SAVE;                    
                    $this->currentTemplate = UserView::TPL_CREATEEDIT;
                }
                else
                {
                    $outText = "Пользователь ". $this->output->login." сохранён успешно! ";                                       
                    $this->output = $outText;
                    $this->currentTemplate = UserView::TPL_SUCCESS;                             
                } 
                break;
            case Actions::CREATE :                
                $this->output = new UserAccount;
                $this->currentTemplate = UserView::TPL_CREATEEDIT;            
                $this->frmAction = "index.php?module=".Modules::USERS."&action=".Actions::SAVE;                
            break;   
            
            case Actions::SHOW :
                if($this->error != null)                
                {                    
                    $mainLayoutTemplate->SetContentTemplate(UserView::TPL_ERROR);
                    $mainLayoutTemplate->ShowPage($this->output, $this->error);                
                }
                else
                {                    
                    $mainLayoutTemplate->SetContentTemplate(UserView::TPL_SHOW);
                    $mainLayoutTemplate->ShowPage($this->output, $this->error);                
                }
                break;
            
            case Actions::EDIT :   //почти то же, что и create
                $mainLayoutTemplate->SetContentTemplate(UserView::TPL_CREATEEDIT);
                $mainLayoutTemplate->ShowPage($this->output, $this->error, "index.php?module=".Modules::USERS."&action=".Actions::SAVE);                                
            break;
            
            case Actions::SHOWLIST :                
                $mainLayoutTemplate->SetContentTemplate(UserView::TPL_SHOWLIST);
                $mainLayoutTemplate->ShowPage($this->output, $this->error,  "index.php?module=".Modules::USERS."&action=".Actions::SHOWLIST);                
            break;
        }
    }
    */
    
    public function ShowErrorPage()
    {
        echo "Error page: ".$this->error;
    }
    
    public function GetMenuItems()
    {                
        $url = "index.php?module=".Modules::USERS."&action=".Actions::SHOWLIST;
        $text = "Пользователи";
        $active = $this->command->action == Actions::SHOWLIST ? true : false;
                        
        $url1 = "index.php?module=".Modules::USERS."&action=".Actions::CREATE;
        $text1 = "Создать";
        $active1 = $this->command->action == Actions::CREATE ? true : false;
                
        $res = Array( new TemplateMenuItem($text, $url, $active),
                      new TemplateMenuItem($text1, $url1, $active1) );
        return $res;
    }
}

?>
