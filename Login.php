<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <?php
            if(isset($_POST['login']))
                    {
                        $tmpUser = LoginHelper::Login($_POST['login'], $_POST['pass']);
                        if(!$tmpUser)
                        {
                            echo "Неверный логин/пароль";
                            echo '<a href="./index.php">Еще раз</a>';
                        }
                        else
                        {
                            if(isset($_POST['prevGet']) && strlen($_POST['prevGet'])>0) 
                            //echo $_POST['prevGet'];
                            ToolsHelper::RedirectTo($_POST['prevGet']);
                        }
                    }
            if(isset($_POST['logout']))
                    {
                        LoginHelper::LogOut();
                    }
            if(!LoginHelper::GetCurrentUser())
            {
                if(strlen($_SERVER['QUERY_STRING']) == 0)
                {?>
                <form action="Index.php" method="post">
                <div name="divLogin" style="border: 1px solid black; width: 220px">
                   <table>
                        <tr>
                            <td>Логин:</td>
                            <td><input type="text" name="login"></input></td>
                        </tr>
                        <tr>
                            <td>Пароль:</td>
                            <td><input type="password" name="pass"></input></td>
                        </tr>
                    </table>
                    <input type='hidden' name='prevGet' value='<?php if(isset($_POST['prevGet'])) echo $_POST['prevGet'] ?>'></input>
                    <input type="submit" name="okbutton" value="Вход"></input>
                </div>
                </form> 
            <?php
                }
                else
                {?>
                    
                <form action="Index.php" method="post">
                <div name="divLogin" style="border: 1px solid black; width: 220px">
                    Вы не авторизованны. Войдите в систему для получения доступа.
                    <input type='hidden' name='prevGet' value='<?php echo $_SERVER['REQUEST_URI'] ?>'></input>
                    <input type="submit" name="okbutton" value="Вход"></input>
                </div>
                </form> 
               <?php }
            }
            //else
            //{
               //echo "Пользователь: ".LoginHelper::GetCurrentUserName();
               //ToolsHelper::RedirectTo('index.php');
               ?>
               <!--
                <br/>
               
               <form action="Index.php" method="post">
                <div name="divLogin" style="border: 1px solid black; width: 220px">
                    <input type="hidden" name="logout" value="1"></input>
                    <input type="submit" name="okbutton" value="Выход"></input>
                </div>
                </form>  -->
                 <?php
            //}
        ?>
    </body>
</html>