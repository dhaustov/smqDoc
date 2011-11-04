<?php
/**
 * Description of UserGroupValidator
 *
 * @author Dmitry
 */
class UserGroupValidator  implements IValidator
{
     private $error;
    
    public function IsValid($group)
    {  
        //TODO: добавить логику валидации
        return true;
    }
    public function GetError()
    {
        return $this->error;
    }
}

?>
