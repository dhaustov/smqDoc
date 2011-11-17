<?php

/**
 * Class for User Repository
 *
 * @author Dmitry G. Haustov
 */
class UserRepository implements IObjectRepository
{        
    private $error;
    
    const TBL_USERACCOUNTS = "useraccounts";
    
    /*
     * IObjectRepository Methods
     */    
    public function Save($user)  
    { 
        /* @var $user UserAccount */
        
        if( $user->id > 0 ) //Updating Existing User
        {
                $query = "update ".UserRepository::TBL_USERACCOUNTS." set 
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
                //return $user->id;
                return true;
        }
        else //Trying to save new user
        {
            if($this->CheckForExists($user))
            {
                $this->error = "Пользователь с таким именем уже существует!";
                return false;
            }

            $query = "insert into ".UserRepository::TBL_USERACCOUNTS." 
                                  (login, password, status, name, surName, middleName) 
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
            $user->id  = $newid;
            //return $newid;
            return true;
        }                
    }
    
    public function Delete($obj)
    { 
        /* @var $user UserAccount */
        $user = $obj;
        $query = "update user_accounts 
                  set status = ".DbRecordStatus::DELETED." 
                  where id =". intval($user->id);
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
        
        $query = "select id, login,password,status, name,surname,middlename,lastaccess 
                  from ".UserRepository::TBL_USERACCOUNTS." 
                  where id = ". intval($id);
        $obj = SqlHelper::ExecSelectRowQuery($query);
        
        if ($obj)
        {
            /* @var $user UserAccount */
            $user->id = $obj['id'];
            $user->login = $obj['login'];
            $user->password = $obj['password'];
            $user->status = $obj['status'];
            $user->name = $obj['name'];
            $user->surName = $obj['surname'];
            $user->middleName = $obj['middlename'];
            $user->lastAccess = $obj['lastaccess'];            
            
            return $user;
        }
        else 
        {
             $this->error = "Пользователь не найден";
            return false;
        }
        
    }
    
    public function CheckForExists($obj)
    { 
        /* @var $user UserAccount */
        $user = $obj;
        
        $query = "select id 
                  from ".UserRepository::TBL_USERACCOUNTS." 
                  where login = '". ToolsHelper::CleanInputString($user->login)."'";
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
        
        $query = "select id,login,password,status,name,surName,middleName, lastAccess 
                  from ".UserRepository::TBL_USERACCOUNTS." 
                  where login = '". ToolsHelper::CleanInputString($login)."'";
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
        {
            $this->error = "Пользователь не найден";
            return false;
        }
        
    }
    
    public function GetList($pageSize = 1, $pageNum = 1, $status = null)
    {                    
        //если pageSize = 1 - выводим всех
        $retArr = false;
        $query = "select id,login,password,status,name,surname,middlename,lastaccess 
                  from ".UserRepository::TBL_USERACCOUNTS." ";
        if($status)
            $query.=" where status = $status";
        
        if($pageSize > 1)        
            $query.=" limit ".((int)$pageNum * (int)$pageSize).",".$pageSize;                
                                
        $res = SqlHelper::ExecSelectCollectionQuery($query);
        $i=0;
        if($res)
        {
            foreach($res as $row)
            {
                $user = new UserAccount(                        
                            $row['login'],
                            $row['password'],                        
                            $row['name'],
                            $row['surname'],
                            $row['middlename'],
                            $row['status'],
                            $row['id'],
                            $row['lastaccess']
                        );
                $retArr[$i] = $user;
                $i++;
            }
        }
        
        if($retArr)
            return $retArr;
        else
        {
            $this->error = "Пользователей не найдено";
            return false;
        }        
    }
        
    public function GetListItemsCount($status = null)
    {
        $query = "select count(*)
                  from ".UserRepository::TBL_USERACCOUNTS." ";
        if($status)
            $query.="  where status = $status";        
        $res = SqlHelper::ExecSelectValueQuery($query);
        
        if($res)
            return $res;
        else return 0;
    }
    
    public function GetError()
    {
        return $this->error;
    }
}

?>
