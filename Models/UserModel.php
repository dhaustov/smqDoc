<?php

/**
 * Description of testModel
 *
 * @author Dmitry
 */
class UserModel implements IModel
{
    /*Действия, которые может выполнять модель*/
    /*
    var $allowedActions = array(
        Actions::CREATE,
        Actions::EDIT,
        Actions::DELETE,
        Actions::SAVE,
        Actions::SHOW,
        Actions::SHOWLIST
    );
    */
        
    /* @var $currentCommand UserCommand */
    var $currentCommand; 
    /* @var $user UserAccount */
    var $user;
    /* @var $repository UserRepository */
    var $repository;
    var $error;
    
    public function __construct($_user = null)
    {
        $this->user = $_user;
        
        if($this->user)
            $this->repository = new UserRepository;
    }
    public function PerformAction($_command)
    {        
        $this->currentCommand = $_command;
        $this->repository = new UserRepository;
        
        $res = false;
        switch($this->currentCommand->action)
        {            
            case Actions::CREATE : //????
                return new UserAccount;
                break;
            case Actions::DELETE :
                $res = $this->repository->Delete($this->user);                                                                               
                break;
            case Actions::SAVE :                
                //где то тут ещё должны быть валидация...
                $tmpUser = new UserAccount(  
                                             $_POST["lblLogin"],
                                             $_POST["lblPassword"],
                                             $_POST["lblName"],                     
                                             $_POST["lblSurname"],                                             
                                             $_POST["lblMiddlename"],
                                             $_POST["status"],
                                             $_POST["hdnUid"]);
                $this->user = $tmpUser;                
                $uid = $this->repository->Save($this->user);
                
                if($uid)                
                    $res = $this->repository->GetById($uid);                
                break;
            
            case Actions::EDIT :
            case Actions::SHOW :
                $this->user = $this->repository->GetById($this->currentCommand->id);
                if($this->user)
                    $res = $this->user;
                break;
            case Actions::SHOWLIST :
                $res = $this->repository->GetList();
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
    /*
    public function GetAllowedActions()
    {
        return $this->allowedActions;
    }
    */
    public function GetError()
    {
        return $this->error;
    }
}

?>
