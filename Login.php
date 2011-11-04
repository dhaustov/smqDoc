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
                        if($tmpUser)
                        {
                           // echo "Здравствуйте $tmpUser->name</br>";
                            include_once 'dt.php';
                        }
                        else
                        {
                            echo "Неверный логин/пароль";
                            echo '<a href="./Index.php">Еще раз</a>';
                        }
                    }
            if(isset($_POST['logout']))
                    {
                        LoginHelper::LogOut();
                    }
            if(!LoginHelper::GetCurrentUser())
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
                    <input type="submit" name="okbutton" value="Вход"></input>
                </div>
                </form> 
            <?php
            }
            else
            {
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
            }
        ?>
    </body>
</html>