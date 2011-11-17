<?php

/**
 * Description of UserValidator
 *
 * @author Dmitry
 */
class UserValidator implements IValidator
{
    private $error;
    
    public function IsValid($user, $passRepeat = "")
    {
        if($user->id > 0)
        {
            //TODO: продумать валидацию для имеющегося пользователя
            if ($passRepeat !="" && $user->password != $passRepeat)
            {
                $this->error = "Введённые пароли не совпадают";
                return false;
            }
        }
        else //валидация нового
        { 
            if ($user->password != $passRepeat)
            {
                $this->error = "Введённые пароли не совпадают";
                return false;
            }
        }
        
        return true;
    }
    public function GetError()
    {
        return $this->error;
    }
}

?>
