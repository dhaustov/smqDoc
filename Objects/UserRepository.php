<?php
//require_once 'User.php';
//require_once '../Helpers/ToolsHelper.php';
//require_once '../Helpers/SqlHelper.php';
//require_once '../Interfaces/IObjectRepository.php';

class UserRepository implements IObjectRepository
{        
    private $error;
    
    //IObjectRepository Methods
    public function Save($obj)     
    { 
        /* @var $user UserAccount */
        $user = $obj;
        
        if( $user->id > 0 ) //Editing Existing User
        {
                $query = "update user_accounts set 
                              login = '".ToolsHelper::CleanInputString($user->Login)."',
                              status = '".ToolsHelper::CleanInputString($user->Status)."', 
                              name = '".ToolsHelper::CleanInputString($user->Name)."',
                              surname = '".ToolsHelper::CleanInputString($user->Surname)."',
                              middlename = '".ToolsHelper::CleanInputString($user->MiddleName)."'
                          where id =". intval($user->id);
                
                $numRows = SqlHelper::ExecUpdateQuery($query);
                
                if(!$numRows)
                {
                    $this->error = "При обновлении пользователя произошла ошибка!";
                    return false;
                }
                return $user->id;
        }
        else //Trying to save new user
        {
            if($this->CheckForExists($user))
            {
                $this->error = "Пользователь с таким именем уже существует!";
                return false;
            }

            $query = "insert into user_accounts (login, password, status, name, surname, middlename) 
                                  values ( '".ToolsHelper::CleanInputString($user->Login)."',
                                           '".ToolsHelper::CleanInputString($user->Password)."',
                                           '".ToolsHelper::CleanInputString($user->Status)."',
                                           '".ToolsHelper::CleanInputString($user->Name)."',
                                           '".ToolsHelper::CleanInputString($user->Surname)."',
                                           '".ToolsHelper::CleanInputString($user->MiddleName)."'
                                          )";

            $newID = SqlHelper::ExecInsertQuery($query);

            if(!$newID)
            {
                $this->error = "При сохранении пользователя возникла ошибка!";
                return false;
            }
            return $newID;
        }                
    }
    
    public function Delete($obj)
    { 
        /* @var $user UserAccount */
        $user = $obj;
        $query = "update user_accounts set status = 0 where id =". intval($user->id);
        $rowNum = SqlHelper::ExecDeleteQuery($query);
        
        if (!$rowNum)
        {
            $this->error = "При удалении пользователя возникла ошибка!";
            return false;
        }
        return $rowNum;
    }
   
    public function GetByID($id) 
    { 
        /* @var $user UserAccount */
        $user = new UserAccount();
        
        $query = "select * from user_accounts where id = ". intval($id);
        $obj = SqlHelper::ExecSelectRowQuery($query);
        
        if ($obj)
        {
            /* @var $user UserAccount */
            $user->Id = $obj['id'];
            $user->Login = $obj['login'];
            $user->Password = $obj['password'];
            $user->Status = $obj['status'];
            $user->Name = $obj['name'];
            $user->Surname = $obj['surname'];
            $user->MiddleName = $obj['middlename'];
            $user->LastAccess = $obj['lastaccess'];            
            
            return $user;
        }
        else 
            return false;
        
    }
    
    public function CheckForExists($obj)
    { 
        /* @var $user UserAccount */
        $user = $obj;
        
        $query = "select id from user_accounts where login = '". ToolsHelper::CleanInputString($user->Login)."'";
        $obj = SqlHelper::ExecSelectValueQuery($query);
        
        if ($obj)
            return true;
        else 
            return false;
        
    }  
    
    //Additional Public Methods
    public function GetByLogin($login)
    {
        /* @var $user UserAccount */
        $user = new UserAccount;
        
        $query = "select * from user_accounts where login = '". ToolsHelper::CleanInputString($login)."'";
        $obj = SqlHelper::ExecSelectRowQuery($query);
        
        if ($obj)
        {
            /* @var $user UserAccount */
            $user->Id = $obj['id'];
            $user->Login = $obj['login'];
            $user->Password = $obj['password'];
            $user->Status = $obj['status'];
            $user->Name = $obj['name'];
            $user->Surname = $obj['surname'];
            $user->MiddleName = $obj['middlename'];
            $user->LastAccess = $obj['lastaccess'];            
            
            return $user;
        }
        else 
            return false;
        
    }
    
    public function GetError()
    {
        return $this->error;
    }
}

?>
