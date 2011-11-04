<?php
/**
 * Description of DocTemplateValidator
 *
 * @author Dmitry
 */
class DocTemplateValidator implements IValidator
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
