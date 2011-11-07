<?php
/**
 * Description of UserGroupDocModel
 *
 * @author Павел
 */
class UserGroupDocModel implements IModel
{
          /* @var $currentCommand UserGroupDocCommand */
    private $currentCommand; 
    /* @var $doc UserGroupDoc */
    private $doc;
    /* @var $repository UserGroupDocRepository */
    private $repository;
    private $error;
    
    public function __construct()
    {
        $this->repository = new UserGroupDocRepository();
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
                $tid = $this->repository->Save($this->template);
                
                if($tid)                
                    $res = $this->repository->GetById($tid);                
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
        return $this->repository->docTemplateFieldTypesArr;
    }
    
    public function GetOperationsList()
    {
        return $this->repository->docTemplateOperationsArr;
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
