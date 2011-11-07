<div id="main">
    <?php if (!$res->id) :?>
    <h2>Создание нового пользователя</h2>
    <?php else :?>
    <h2>Редактировать пользователя</h2>
    <?php endif;?>
<form name="frmNewUser" method="POST" action="<?php echo $frmAction; ?>" />
    <table>
        <tr>
            <td>  
                Логин:
            </td>
            <td>      
                <input type="text" name="lblLogin" value="<?php echo  $res->login; ?>" />
            </td>
        </tr>
        <tr>
            <td>
                Пароль:
            </td>
            <td>                
                <input type="password" name="lblPassword" value="<?php echo $res->password; ?>" />
            </td>
        </tr>
        <tr>
            <td>       
                Повторите пароль:
            </td>
            <td>                
                <input type="password" name="lblRetypePassword" value="<?php $res->password; ?>" />
            </td>
        </tr>
        <tr>
            <td>                
                Фамилия:
            </td>
            <td>                
                <input type="text" name="lblSurname" value="<?php echo $res->surName; ?>" />
            </td>
        </tr>
        <tr>
            <td>                
                Имя:
            </td>
            <td>                
                <input type="text" name="lblName" value="<?php echo $res->name; ?>" />
            </td>
        </tr>
        <tr>
            <td>    
                Отчество: 
            </td>
            <td>                
                <input type="text" name="lblMiddlename" value="<?php echo $res->middleName; ?>" />
            </td>
        </tr>
        <tr>
            <td>   
                Статус:
            </td>
            <td>       
                <select name="status" >
                    <option value="<?php echo DbRecordStatus::ACTIVE; ?>" <?php if($res->status == DbRecordStatus::ACTIVE) echo "selected=\"selected\""; ?> >Активный</option>
                    <option value="<?php echo DbRecordStatus::DELETED; ?>" <?php if($res->status == DbRecordStatus::DELETED) echo "selected=\"selected\""; ?> >Неактивный</option>
                </select>
            </td>
        </tr>
    </table>
    <input type="hidden" name="hdnUid" value="<?php echo $res->id; ?>" />
    <span class="error"><?php echo $error; ?></span>
    <input type="submit" value="Сохранить" />
</form>    
</div>

