<?php
/**
 * Description of UserGroupDocValidator
 *
 * @author Dmitry
 */
class UserGroupDocValidator implements IValidator
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
