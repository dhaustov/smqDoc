<!--<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>-->
Возникла внутренняя ошибка системы: <br />
<?php
    if(strlen(session_id())==0)
        session_start();
    if(isset($_SESSION['Error']))
    {
        echo $_SESSION['Error'];
        unset($_SESSION['Error']);
    }
    if(isset($error))
        echo $error;
    
?>
<!--    </body>
</html>-->
