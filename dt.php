<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>

<?php

/*
 * Test file for D. Haustov
 * 
 */
    require_once "Init.php";

    /* @var $usr UserAccount */
    $usr = new UserAccount("login", "pass", "1", "Dmitry", "Haustov", "G");
    $usr2 = new UserAccount("login2", "pass2", "1", "Pavel", "Serdukov", "A");
    /* @var $ur UserRepository */
    $ur = new UserRepository;            

    echo "user_login: ".$usr->login."<br />";
    $id = $ur->Save($usr);
    $id2 = $ur->Save($usr2);
    if(!$id)
        echo "Error:".$ur->GetError()."<br />";
    else                
        echo "new id:".$id."<br />";
    echo "user_login: ".$usr->login."<br />";
    
    echo "Ищем пользователя ".$usr->login." по логину...<br />";
    $usr = $ur->GetByLogin($usr->login);
    
    if(!$usr)
        echo "Error: ".$ur->GetError()."<br />";
    else
        echo "User id: ".$usr->id."<br />";

    $usr->login="login_upd";
    $res = $ur->Save($usr);

    if(!$res)            
        echo "Ошибка сохранения изменённого. Error: ".$ur->GetError()."<br />";                            
    else 
        echo "Пользователь изменён и сохранён, id: ".$res."<br />";

    $id = $usr->id; //id препарируемого
    $usr = $ur->GetById($id);
    echo "user login:".$usr->login."<br />";
    if(!$usr)
        echo "Пользователь ".$usr->id." не найден по id. Error: ".$ur->GetError()."<br />";
    else
    {
        echo "Пользователь найден id=".$usr->id.", удаляем<br />";
        $res = $ur->Delete($usr);
        if(!$res)
            echo "Ошибка удаления. Error: ".$ur->GetError()."<br />";
        else
            echo "Удалён!<br />";
    }
    
    $lst = $ur->GetList();
    echo "Список: <br />";
    if(!$lst)
        echo $ur->GetError();
    else
    {
        foreach ($lst as $u)
            echo "login: ".$u->login."<br />";
    }
?>
    </body>
</html>
