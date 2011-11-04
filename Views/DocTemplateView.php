<?php
/**
 * Description of DocTemplateView
 *
 * @author Dmitry
 */
class DocTemplateView implements IView
{
    const TPL_CREATEEDIT = '/templates/DocTemplate/templateCreateEdit.php';    
    const TPL_SHOW = '/templates/DocTemplate/templateInfo.php';
    const TPL_SHOWLIST = '/templates/DocTemplate/templateList.php';
    const TPL_SUCCESS = '/templates/DocTemplate/templateSuccess.php';
    const TPL_ERROR = '/templates/ErrorPage.php';
    
    private $command;    
    private $res;
    private $error = "";
    
    public $totalItems;    
    public $frmAction;
    public $lstFieldTypes;
    public $lstOperations;
    
    public $currentTemplate;
    
    function __construct(DocTemplateCommand $_command = null)
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
                    //собираем с формы поля
                    $fields = Array();                
                    $cntFields = $_POST['totalFieldsCount']; //общее количество полей на форме
                    $i=0; 
                    $cnt = 1; //счётчик для id
                    while($i<$cntFields)
                    {
                        if($_POST['lblName'.$cnt])
                        {                        
                            $calc =  isset($_POST['chkIsCalculated'.$cnt]) ? $_POST['chkIsCalculated'.$cnt] : null;
                            $restr = isset($_POST['chkIsRestricted'.$cnt]) ? $_POST['chkIsRestricted'.$cnt] : null;
                            $min = isset($_POST['lblMinValue'.$cnt]) ? $_POST['lblMinValue'.$cnt] : null;
                            $max = isset($_POST['lblMaxValue'.$cnt]) ? $_POST['lblMaxValue'.$cnt] : null;
                            $id = isset($_POST['hdnId'.$cnt]) ? $_POST['hdnId'.$cnt] : null;
                            $ft = isset($_POST['selFieldType'.$cnt]) ? $_POST['selFieldType'.$cnt] : null;
                            $ot = isset($_POST['selOper'.$cnt]) ? $_POST['selOper'.$cnt] : null;   
                            
                            //TODO: неправильно это как то...
                            $fieldType = new DocTemplateFieldType(null,null,$ft);                        
                            $operType = new DocTemplateOperation(null,null,$ot);
                            
                            $field = new DocTemplateField($_POST['lblName'.$cnt],$calc,$fieldType,$restr,$min,$max,$operType,$id);

                            $fields[] = $field;
                            $i++;
                        }                        
                        $cnt++;
                    }
                
                    $this->res =  new DocTemplate(  $_REQUEST["lblName"],
                                                    "",
                                                    $fields
                                                 );
                    $this->currentTemplate = DocTemplateView::TPL_CREATEEDIT;
                    $this->frmAction = "index.php?module=".Modules::DOCTEMPLATES."&action=".Actions::SAVE;
                }
                else
                {
                    $outText = "Шаблон ". $this->res->name." сохранён успешно! ";                                       
                    $this->res = $outText;
                    $this->currentTemplate = DocTemplateView::TPL_SUCCESS;                    
                } 
                break;
            case Actions::CREATE :                
                $this->res = new DocTemplate();
                $this->currentTemplate = DocTemplateView::TPL_CREATEEDIT;                                    
                $this->frmAction = "index.php?module=".Modules::DOCTEMPLATES."&action=".Actions::SAVE;
            break;   
            
            case Actions::SHOW :
                if($this->error != null)                
                {           
                    $this->currentTemplate = DocTemplateView::TPL_ERROR;                    
                }
                else
                {   
                    $this->currentTemplate = DocTemplateView::TPL_SHOW;                    
                }
                break;
            
            case Actions::EDIT :   //почти то же, что и create
                if($this->error != null)                
                {           
                    $this->currentTemplate = DocTemplateView::TPL_ERROR;                    
                }
                else
                {   
                    $this->currentTemplate = DocTemplateView::TPL_CREATEEDIT;
                    $this->frmAction = "index.php?module=".Modules::DOCTEMPLATES."&action=".Actions::SAVE;
                }
            break;
            
            case Actions::SHOWLIST :                
                $this->currentTemplate = DocTemplateView::TPL_SHOWLIST;                
                $this->frmAction = "index.php?module=".Modules::DOCTEMPLATES."&action=".Actions::SHOWLIST;
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
        
        $lstFieldTypes = $this->lstFieldTypes;
        $lstOperations = $this->lstOperations;
                
        include_once $this->currentTemplate;    
    }
    
    
    public function ShowErrorPage()
    {
        echo "Error page: ".$this->error;
    }
    
    public function GetMenuItems()
    {                
        $url = "index.php?module=".Modules::DOCTEMPLATES."&action=".Actions::SHOWLIST;
        $text = "Список шаблонов";
        $active = $this->command->action == Actions::SHOWLIST ? true : false;
                        
        $url1 = "index.php?module=".Modules::DOCTEMPLATES."&action=".Actions::CREATE;
        $text1 = "Создать шаблон";
        $active1 = $this->command->action == Actions::CREATE ? true : false;
                
        $res = Array( new TemplateMenuItem($text, $url, $active),
                      new TemplateMenuItem($text1, $url1, $active1) );
        return $res;
    }
}

?>
