<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <?php
            require_once 'Helpers/NotificationHelper.php';

            echo  NotificationHelper::SendErrorMailToDeveloper("Test message2", "message2222");
    
?>
    </body>
</html>

