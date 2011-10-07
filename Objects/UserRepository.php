<?php

/**
 * Class for User Repository
 *
 * @author Dmitry G. Haustov
 */
class UserRepository implements IObjectRepository
{        
    private $error;
    
    /*
     * IObjectRepository Methods
     */
    
    public function Save($obj)  
    { 
        /* @var $user UserAccount */
        $user = $obj;
        
        if( $user->id > 0 ) //Updating Existing User
        {
                $query = "update user_accounts set 
                              login = '".ToolsHelper::CleanInputString($user->login)."',
                              status = '".ToolsHelper::CleanInputString($user->status)."', 
                              name = '".ToolsHelper::CleanInputString($user->name)."',
                              surName = '".ToolsHelper::CleanInputString($user->surName)."',
                              middleName = '".ToolsHelper::CleanInputString($user->middleName)."'
                          where id =". intval($user->id);
                
                $numRows = SqlHelper::ExecUpdateQuery($query);
                                
                if(!$numRows)
                {
                    $this->error = "При обновлении пользователя произошла ошибка!";
                    NotificationHelper::LogCritical("Error in class: '".__CLASS__."' method: '".__METHOD__."' query: '$query'");
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

            $query = "insert into user_accounts (login, password, status, name, surName, middleName) 
                                  values ( '".ToolsHelper::CleanInputString($user->login)."',
                                           '".ToolsHelper::CleanInputString($user->password)."',
                                           '".ToolsHelper::CleanInputString($user->status)."',
                                           '".ToolsHelper::CleanInputString($user->name)."',
                                           '".ToolsHelper::CleanInputString($user->surName)."',
                                           '".ToolsHelper::CleanInputString($user->middleName)."'
                                          )";

            $newid = SqlHelper::ExecInsertQuery($query);

            if(!$newid)
            {
                $this->error = "При сохранении пользователя возникла ошибка!";
                NotificationHelper::LogCritical("Error in class: '".__CLASS__."' method: '".__METHOD__."' query: '$query'");
                return false;
            }
            return $newid;
        }                
    }
    
    public function Delete($obj)
    { 
        /* @var $user UserAccount */
        $user = $obj;
        $query = "update user_accounts set status = ".UserStatus::DELETED." where id =". intval($user->id);
        $rowNum = SqlHelper::ExecDeleteQuery($query);
                
        if (!$rowNum)
        {
            $this->error = "При удалении пользователя возникла ошибка!";
            NotificationHelper::LogCritical("Error in class: '".__CLASS__."' method: '".__METHOD__."' query: '$query'");
            return false;
        }
        return $rowNum;
    }
   
    public function GetById($id) 
    { 
        /* @var $user UserAccount */
        $user = new UserAccount();
        
        $query = "select id, login,password,status, name,surname,middlename,lastaccess from user_accounts where id = ". intval($id);
        $obj = SqlHelper::ExecSelectRowQuery($query);
        
        if ($obj)
        {
            /* @var $user UserAccount */
            $user->id = $obj['id'];
            $user->login = $obj['login'];
            $user->password = $obj['password'];
            $user->status = $obj['status'];
            $user->name = $obj['name'];
            $user->surName = $obj['surName'];
            $user->middleName = $obj['middleName'];
            $user->lastAccess = $obj['lastAccess'];            
            
            return $user;
        }
        else 
            return false;
        
    }
    
    public function CheckForExists($obj)
    { 
        /* @var $user UserAccount */
        $user = $obj;
        
        $query = "select id from user_accounts where login = '". ToolsHelper::CleanInputString($user->login)."'";
        $obj = SqlHelper::ExecSelectValueQuery($query);
        
        if ($obj)
            return true;
        else 
            return false;
        
    }  
    
    /*
     * Additional Methods
     */
    public function GetByLogin($login)
    {
        /* @var $user UserAccount */
        $user = new UserAccount;
        
        $query = "select id,login,password,status,name,surName,middleName, lastAccess from user_accounts where login = '". ToolsHelper::CleanInputString($login)."'";
        $obj = SqlHelper::ExecSelectRowQuery($query);                
        if ($obj)
        {
            /* @var $user UserAccount */
            $user->id = $obj['id'];
            $user->login = $obj['login'];
            $user->password = $obj['password'];
            $user->status = $obj['status'];
            $user->name = $obj['name'];
            $user->surName = $obj['surName'];
            $user->middleName = $obj['middleName'];
            $user->lastAccess = $obj['lastAccess'];                                    
            return $user;
        }
        else 
            return false;
        
    }
    
    public function GetList($status = null)
    {
        $retArr = false;
        $query = "select id,login,password,status,name,surname,middlename,lastaccess from user_accounts ";
        if($status)
            $query.=" where status = $status";
        $res = SqlHelper::ExecSelectCollectionQuery($query);
        $i=0;
        foreach($res as $row)
        {
            $user = new UserAccount(                        
                        $row['login'],
                        $row['password'],
                        $row['status'],
                        $row['name'],
                        $row['surname'],
                        $row['middlename'],
                        $row['id'],
                        $row['lastaccess']
                    );
            $retArr[$i] = $user;
            $i++;
        }
        if($retArr)
            return $retArr;
        else
        {
            $this->error = "Пользователей не найдено";
            return false;
        }        
    }
    
    public function GetError()
    {
        return $this->error;
    }
}

?>
