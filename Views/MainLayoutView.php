<?php

/**
 * A veiw for main layout template
 * $res is passing to tpl_content
 * @author Dmitry
 */
class MainLayoutView implements IMasterPageView
{
    const TPL_MAIN =  "/templates/MainLayout/mainLayout.php";
    const TPL_HEADER = "/templates/MainLayout/header.php";
    const TPL_MENU = "/templates/MainLayout/menu.php";
    const TPL_FOOTER = "/templates/MainLayout/footer.php";
    const TPL_HRMENU = "/templates/MainLayout/hrmenu.php";
    /* content for layout parts */
    public $title;
    public $header;
    public $menu;
    public $footer;
    
    private $tpl_content;
    private $childView;
    
    public function __construct($_tplContent = null)
    {
        $this->tpl_content = $_tplContent;
    }
    
    public function SetContentTemplate($_tpl)
    {
        $this->tpl_content = $_tpl;
    }
   
    /*
    public function ShowPage($res=null, $error=null, $formAction=null)
    {
        include_once MainLayoutView::TPL_MAIN;
    }
    */
    
    public function ShowPage($_view)
    {
        $this->childView = $_view;
        include_once MainLayoutView::TPL_MAIN;    
    }
            
}

?>
