<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <?php
            require_once 'Helpers/NotificationHelper.php';

            SqlHelper::ExecInsertQuery("INSERT INTO doctemplate_operations (name,code) VALUES('str','str2')");
            SqlHelper::ExecInsertQuery("INSERT INTO doctemplate_operations (name,code) VALUES('str3','str4')");
            $arr = SqlHelper::ExecSelectCollectionQuery("Select * from doctemplate_operations");
            foreach( $arr as $val )
            {
                echo "val: ".$val['name'].":".$val['code']."<br>";
            }
?>
    </body>
</html>

