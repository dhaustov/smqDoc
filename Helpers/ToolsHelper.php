<?php

/*
 * Misc fuctnions
 */
class ToolsHelper {
    public static function RedirectTo($page)
    {
        header("Request-URI: ".$page);
        header("Content-Location: ".$page);
        header("Location: ".$page);
    }
    
    public static function RedirectToErrorPage($error = "")
    {          
        header("Request-URI: templates/ErrorPage.php");
        header("Content-Location: templates/ErrorPage.php");
        header("Location: templates/ErrorPage.php");         
    }
    
    public static function CleanInputString($input /*, $sql=false*/) 
    {
        $input = htmlentities($input, ENT_QUOTES, 'UTF-8');
        // мнемонизировали строку.
        if(get_magic_quotes_gpc ())
        {
            $input = stripslashes ($input);
            // убрали лишнее теперь экранирование.
        }
        /*
        if ($sql)
        {
            $input = mysql_real_escape_string ($input);
            // если нужен MySQL-запрос, то делаем соответствующую очистку. 
            // Подключение к базе должно быть активным!
        }*/
        $input = strip_tags($input);
        //режем теги.
        $input=str_replace ("\n"," ", $input);
        $input=str_replace ("\r","", $input);
        //обрабатываем переводы строки.
        return $input;
    }
    public static function RealEscapeString($str)
    {
        return SqlHelper::Real_escape_string($str);
    }
}

?>
