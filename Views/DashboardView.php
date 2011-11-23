<?php
/**
 * Description of testView
 *
 * @author Dmitry
 */
class DashboardView implements IView
{       
    const TPL_SHOW = '/templates/Dashboard/dashboardShow.php';
    
    private $error;
    private $res;
    private $currentTemplate;
    public $frmAction;
    
    function __construct()
    { 
    }
         
    public function SetResult($_res=null, $_error = null)
    {
        $this->res = $_res;
        $this->error = $_error;
        $this->currentTemplate = DashboardView::TPL_SHOW;  
        $this->frmAction = "index.php?module=".Modules::DASHBOARD."&action=".Actions::SAVE;
    }
    
    
    public function ShowPage()
    {
        //Переменные для вывода в шаблоне
        $res = $this->res;
        $error = $this->error;
        $frmAction = $this->frmAction;
        include_once $this->currentTemplate;    
    }
    
 
    
    public function ShowErrorPage()
    {
        echo "Error page: ".$this->error;
    }
    
    public function GetMenuItems()
    {                
        $url = "index.php?module=".Modules::USERS."&action=".Actions::EDIT."&id=".LoginHelper::GetCurrentUserId();
        $text = "Редактировать <br>мои данные";         
       
        $url1 = "index.php?module=".Modules::USERS."&action=".Actions::SHOW."&id=".LoginHelper::GetCurrentUserId();
        $text1 = "Показать <br>мои данные";
                
        $res = Array( new TemplateMenuItem($text1, $url1, true),new TemplateMenuItem($text, $url, true) );
        return $res;
    }
}

?>
