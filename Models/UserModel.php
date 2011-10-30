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
        
    }
    public function PerformAction($_command)
    {        
        $this->currentCommand = $_command;
        $this->repository = new UserRepository;
        
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
    
    public function GetError()
    {
        return $this->error;
    }
}

?>
