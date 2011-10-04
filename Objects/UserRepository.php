<?php
require_once ("../Interfaces/IObjectRepository.php");
require_once ("../Helpers/ToolsHelper.php");
require_once ("../Helpers/SqlHelper.php");
require_once ("User.php");

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
                          ";
                $numRows = SqlHelper::ExecUpdateQuery($query);
                
                if(!$numRows)
                {
                    $this->error = "При сохранении редактируемого пользователя произошла ошибка!";
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
                                           '".ToolsHelper::CleanInputString($user->MiddleName)."',
                                          )";

            $newID = SqlHelper::ExecInsertQuery($query);

            if(!$newID)
            {
                $this->error = "При сохранении нового пользователя произошла ошибюка!";
                return false;
            }
            return $newID;
        }                
    }
    
    public function Delete($obj)
    { }
    
    public function GetByID($id) 
    { }
    
    public function CheckForExists($obj)
    { }  
    
    //Additional Public Methods
    
    
    //System Methods
    private function IsValid($obj)
    {
        //add validation logic here
        return true;
    }
}

?>
