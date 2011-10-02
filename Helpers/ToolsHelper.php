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
    public static function RedirectToErrorPage()
    {
        header("Request-URI: ErrorPage.php");
        header("Content-Location: ErrorPage.php");
        header("Location: ErrorPage.php");
    }
}

?>
