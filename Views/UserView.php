<?php
/**
 * Description of testView
 *
 * @author Dmitry
 */
class UserView
{       
    const TPL_CREATE = '/templates/UserAccount/userCreate.php';
    const TPL_EDIT = '/templates/UserAccount/userEdit.php';
    const TPL_SHOW = '/templates/UserAccount/userInfo.php';
    const TPL_SHOWLIST = '/templates/UserAccount/userList.php';
    const TPL_SUCCESS = '/templates/UserAccount/userSuccess.php';
    const TPL_ERROR = '/templates/errorPage.php';
    
    var $action;
    var $id;
    var $pageSize;
    var $pageNum;
    
    var $output;
    var $error;
    
    function __construct($_action=null, $_id=null, $_pageSize=null, $_pageNum=null)
    {
        $this->action = $_action;
        $this->id = $_id;
        $this->pageNum = $_pageNum;
        $this->pageSize = $_pageSize;
    }
        
    
    public function ShowPage($_res = null, $_error = null)
    {
        $this->output = $_res;
        $this->error = $_error;
        
        $mainLayoutTemplate = new MainLayoutView(UserView::TPL_CREATE);
        $mainLayoutTemplate->title = "Система менеджмента качества";               
        $mainLayoutTemplate->header = new TemplateHeaderItem("Управление учётными записями пользователей");                
        $mainLayoutTemplate->footer = new TemplateFooterItem( __CLASS__ );                                
        $mainLayoutTemplate->menu = $this->GetMenuItems();
        
        switch($this->action)
        {
            
            case Actions::SAVE :
                if($this->error != null)
                {
                    $this->output = new UserAccount(  $_REQUEST["lblLogin"],
                                             $_REQUEST["lblPassword"],
                                             $_REQUEST["lblName"],                     
                                             $_REQUEST["lblSurname"],                                             
                                             $_REQUEST["lblMiddlename"],
                                             $_REQUEST["status"]);
                                        
                    $mainLayoutTemplate->SetContentTemplate(UserView::TPL_CREATE);
                    $mainLayoutTemplate->ShowPage($this->output, $this->error, "index.php?module=".Modules::USERS."&action=".Actions::SAVE);                
                }
                else
                {
                    $outText = "Пользователь ". $this->output->login." сохранён успешно! ";                                       
                    $mainLayoutTemplate->SetContentTemplate(UserView::TPL_SUCCESS);
                    $mainLayoutTemplate->ShowPage($outText);                
                } 
                break;
            case Actions::CREATE :                
                $this->output = new UserAccount;
                                
                $mainLayoutTemplate->SetContentTemplate(UserView::TPL_CREATE);
                $mainLayoutTemplate->ShowPage($this->output, $this->error, "index.php?module=".Modules::USERS."&action=".Actions::SAVE);                
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
                $mainLayoutTemplate->SetContentTemplate(UserView::TPL_CREATE);
                $mainLayoutTemplate->ShowPage($this->output, $this->error, "index.php?module=".Modules::USERS."&action=".Actions::SAVE);                                
            break;
            
            case Actions::SHOWLIST :
                $mainLayoutTemplate->SetContentTemplate(UserView::TPL_SHOWLIST);
                $mainLayoutTemplate->ShowPage($this->output, $this->error);                
            break;
        }
                
    }
    
    public function ShowErrorPage()
    {
        echo "Error page: ".$this->error;
    }
    
    public function GetMenuItems()
    {                
        $url = "index.php?module=".Modules::USERS."&action=".Actions::SHOWLIST;
        $text = "Пользователи";
        $active = $this->action == Actions::SHOWLIST ? true : false;
                        
        $url1 = "index.php?module=".Modules::USERS."&action=".Actions::CREATE;
        $text1 = "Создать";
        $active1 = $this->action == Actions::CREATE ? true : false;
                
        $res = Array( new TemplateMenuItem($text, $url, $active),
                      new TemplateMenuItem($text1, $url1, $active1) );
        return $res;
    }
}

?>
