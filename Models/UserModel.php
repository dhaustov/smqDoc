<?php

/**
 * User Account model
 *
 * @author Dmitry
 */
class UserModel implements IModel
{      
    /* @var $currentCommand UserCommand */
    private $currentCommand; 
    /* @var $user UserAccount */
    private $user;
    /* @var $repository UserRepository */
    private $repository;
    private $error;
    
    public function __construct()
    {
        $this->repository = new UserRepository;
    }
    public function PerformAction($_command)
    {        
        $this->currentCommand = $_command;
                
        $res = false;
        switch($this->currentCommand->action)
        {            
            case Actions::CREATE :
                return new UserAccount;
                break;
            case Actions::DELETE :
                $res = $this->repository->Delete($this->user);                                                                               
                break;
            case Actions::SAVE :              
                $validator = new UserValidator();                
                $this->user = new UserAccount(  $_POST["lblLogin"],
                                                 $_POST["lblPassword"],
                                                 $_POST["lblName"],                     
                                                 $_POST["lblSurname"],                                             
                                                 $_POST["lblMiddlename"],
                                                 $_POST["status"],
                                                 $_POST["hdnUid"]);
                
                if(!$validator->IsValid($this->user, $_POST["lblRetypePassword"])) //валидируем
                {
                    $this->error = $validator->GetError();
                    return false;
                }
                
                if($this->repository->Save($this->user));
                    $res = $this->user;
                break;
            
            case Actions::EDIT :
            case Actions::SHOW :
                $this->user = $this->repository->GetById($this->currentCommand->id);
                if($this->user)
                    $res = $this->user;
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
