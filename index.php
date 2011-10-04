<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <?php
            require_once 'Helpers/NotificationHelper.php';

            echo  NotificationHelper::LogInformation("info");
            echo  NotificationHelper::LogWarning("warning");
            echo  NotificationHelper::LogCritical("Critical");
    
?>
    </body>
</html>

