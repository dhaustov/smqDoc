<div id="main">
    <h2>Информация о пользователе:</h2>

    <table>
        <tr>
            <td>  
                Логин:
            </td>
            <td>      
                <?php echo  $res->login; ?>
            </td>
        </tr>        
        <tr>
            <td>                
                Фамилия:
            </td>
            <td>                
                <?php echo $res->surName; ?>
            </td>
        </tr>
        <tr>
            <td>                
                Имя:
            </td>
            <td>                
                <?php echo $res->name; ?>
            </td>
        </tr>
        <tr>
            <td>    
                Отчество: 
            </td>
            <td>                
                <?php echo $res->middleName; ?>
            </td>
        </tr>
        <tr>
            <td>   
                Статус:
            </td>
            <td>       
                <?php echo $res->status == DbRecordStatus::ACTIVE ? "Активный" : "Неактивный";  ?>                
            </td>
        </tr>
    </table>
    <span class="error"><?php echo $error; ?></span>

</div>