<?php
/**
 * Descibes a menu item for generating html markup
 *
 * @author Dmitry
 */
class TemplateMenuItem
{
    public $url;
    public $text;
    public $active;
    
    public function __construct($_text, $_url, $_actve = null)
    {
        $this->url = $_url;
        $this->text = $_text;
        $this->active = $_actve;
    }
}

?>
