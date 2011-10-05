<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <?php
            require_once 'Init.php';
                       
            /* @var $usr UserAccount */
            $usr = new UserAccount("login", "pass", 2, "Dmitry", "Haustov", "G");
            /* @var $ur UserRepository */
            $ur = new UserRepository;            
            
            echo "user_login: ".$usr->Login."<br />";
            $id = $ur->Save($usr);
            if(!$id)
                echo "Error:".$ur->GetError()."<br />";
            else                
                echo "new id:".$id."<br />";
            echo "user_login: ".$usr->Login."<br />";
            
            echo "Ищем пользователя ".$usr->Login." по логину...<br />";
            $usr = $ur->GetByLogin($usr->Login);
            
            if(!$usr)
                echo "Error: ".$ur->GetError()."<br />";
            else
                echo "User id: ".$usr->Id."<br />";
            
            $usr->Login="login_upd";
            $res = $ur->Save($usr);
            
            if(!$res)            
                echo "Ошибка сохранения изменённого. Error: ".$ur->GetError()."<br />";                            
            else 
                echo "Пользователь изменён и сохранён, строк затронуто: ".$res."<br />";
            
            $id = $usr->id; //id препарируемого
            $usr = $ur->GetByID($id);
            if(!$usr)
                echo "Пользователь ".$usr->Id." не найден по id. Error: ".$ur->GetError()."<br />";
            else
            {
                $res = $ur->Delete($usr);
                if(!$res)
                    echo "Ошибка удаления. Error: ".$ur->GetError()."<br />";
                else
                    echo "Удалён!<br />";
            }
            
            //echo  NotificationHelper::SendErrorMailToDeveloper("Test message2", "message2222");
    
?>
    </body>
</html>

