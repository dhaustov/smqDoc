<?php

/**
 * A veiw for main layout template
 * $res is passing to tpl_content
 * @author Dmitry
 */
class MainLayoutView implements IView
{
    const TPL_MAIN =  "/templates/MainLayout/mainLayout.php";
    const TPL_HEADER = "/templates/MainLayout/header.php";
    const TPL_MENU = "/templates/MainLayout/menu.php";
    const TPL_FOOTER = "/templates/MainLayout/footer.php";
    
    /* content for layout parts */
    public $title;
    public $header;
    public $menu;
    public $footer;
    
    private $tpl_content;
    
    public function __construct($_tplContent = null)
    {
        $this->tpl_content = $_tplContent;
    }
    
    public function SetContentTemplate($_tpl)
    {
        $this->tpl_content = $_tpl;
    }
   
    public function ShowPage($res=null, $error=null, $formAction=null)
    {
        include_once MainLayoutView::TPL_MAIN;
    }
            
}

?>
