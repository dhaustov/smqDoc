<?php
/**
 * Description of DocTemplateModel
 *
 * @author Dmitry
 */
class DocTemplateModel implements IModel
{
    /* @var $currentCommand DocTemplateCommand */
    private $currentCommand; 
    /* @var $template DocTemplate */
    private $template;
    /* @var $repository DocTemplateRepository */
    private $repository;
    private $error;
    
    public function __construct()
    {
        $this->repository = new DocTemplateRepository();
    }
    
    public function PerformAction($_command)
    {        
        $this->currentCommand = $_command;
                
        $res = false;
        switch($this->currentCommand->action)
        {            
            case Actions::CREATE :
                $res = new DocTemplate();
                break;
            case Actions::DELETE :
                $res = $this->repository->Delete($this->template);                                                                               
                break;
            case Actions::SAVE :              
                $validator = new DocTemplateValidator();
                
                //собираем с формы поля
                $fields = Array();                
                $cntFields = $_POST['totalFieldsCount']; //общее количество полей на форме
                $i=0; 
                $cnt = 1; //счётчик для id
                while($i<$cntFields)
                {
                    if($_POST['lblName'.$cnt])
                    {                        
                        $calc =  isset($_POST['chkIsCalculated'.$cnt]) ? true : false;
                        $restr = isset($_POST['chkIsRestricted'.$cnt]) ? true : false;
                        $min = isset($_POST['lblMinValue'.$cnt]) ? $_POST['lblMinValue'.$cnt] : null;
                        $max = isset($_POST['lblMaxValue'.$cnt]) ? $_POST['lblMaxValue'.$cnt] : null;
                        $id = isset($_POST['hdnId'.$cnt]) ? $_POST['hdnId'.$cnt] : null;
                        $ft = isset($_POST['selFieldType'.$cnt]) ? $_POST['selFieldType'.$cnt] : null;                         

                        $field = new DocTemplateField($_POST['lblName'.$cnt],$calc,$ft,$restr,$min,$max,$id);

                        $fields[] = $field;
                        $i++;
                    }                        
                    $cnt++;
                }
                                
                $tmpTpl = new DocTemplate( $_POST['lblName'],
                                           $_POST['hdnTid'],
                                           $fields
                                         );
                
                
                if(!$validator->IsValid($tmpTpl)) //валидируем
                {
                    $this->error = $validator->GetError();
                    return false;
                }
                $this->template = $tmpTpl;                
                $tres = $this->repository->Save($this->template);
                
                if($tres)                
                    $res = $this->repository->GetById($this->template->id);                
                break;
            
            case Actions::EDIT :
            case Actions::SHOW :
                $this->template = $this->repository->GetById($this->currentCommand->id);
                if($this->template)
                    $res = $this->template;
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
            return $res; 
        else
        {
            $this->error = $this->repository->GetError();
            return false;        
        }
    }
    
    public function GetFieldTypesList()
    {
        //return $this->repository->docTemplateFieldTypesArr;
 
        $item1['id']= EnDocTemplateFieldTypes::STRING;
        $item1['name']= "Строка";
        $item2['id']= EnDocTemplateFieldTypes::INT;
        $item2['name']= "Целое";
        $item3['id']= EnDocTemplateFieldTypes::BOOL;
        $item3['name']= "Двочиное";
        $retval[] = $item1;
        $retval[] = $item2;
        $retval[] = $item3; 
        return $retval;
    }
        
    public function GetListItemsCount()
    {
        return $this->repository->GetListItemsCount();
    }
    
    public function GetError()
    {
        return $this->error;
    }
}

?>
