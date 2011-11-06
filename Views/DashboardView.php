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
   
    private $currentTemplate;
    
    function __construct()
    { 
    }
         
    public function SetResult($_res=null, $_error = null)
    {
        $this->error = $_error;
        $this->currentTemplate = DashboardView::TPL_SHOW;  
    }
    
    
    public function ShowPage()
    {
        //Переменные для вывода в шаблоне
        $error = $this->error;
        
        include_once $this->currentTemplate;    
    }
    
 
    
    public function ShowErrorPage()
    {
        echo "Error page: ".$this->error;
    }
    
    public function GetMenuItems()
    {                
        
        $res = Array();
        return $res;
    }
}

?>
