<div id="main">
<h2>Создание новой группы:</h2>
<form name="frmNewUser" method="POST" action="<?php echo $frmAction; ?>" />
    <table>
        <tr>
            <td>  
                Название группы:
            </td>
            <td>      
                <input type="text" name="lblName" value="<?php echo $res->name; /*$res->name;*/ ?>" />
            </td>
        </tr>
        <tr>
            <td>
                Наименование роли главного пользователя:
            </td>
            <td>                
                <input type="text" name="lblMasterUserRole" value="<?php echo $res->masterUserAccountRole; /*$res->masterUserAccountRole;*/ ?>" />
            </td>
        </tr>
        
        <tr>
            <td>   
                Главный пользователь группы:
            </td>
            <td>
                <select name="selIdMasterUser">                    
                    <?php 
                        if( $userAccounts  )
                        {
                            foreach($userAccounts as $acc)
                            {
                                $sel = "";
                                if($acc->id == $res->idMasterUserAccount)
                                   $sel = " selected=\"selected\" ";

                                echo "<option value=\"".$acc->id."\" $sel>".$acc->login." (".$acc->surName." ".$acc->name." ".$acc->middleName.")</option>"; 
                            }                        
                        }
                        else
                            echo "<option value=''>Ошибка! Пользователей не найдено</option> ";
                    ?>
                </select>                
            </td>
        </tr>
        <tr>
            <td>   
                Родительская группа:
            </td>
            <td>
                <select name="selIdParentGroup"> 
                    <option value=''>---</option> ";
                    <?php 
                        if( $otherGroups )
                        {
                            foreach($otherGroups as $gr)
                            {
                                $sel = "";
                                if($gr->id == $res->idParentGroup)
                                   $sel = " selected=\"selected\" ";
                                
                                if($gr->id != $res->id)
                                    echo "<option value=\"".$gr->id."\" $sel>".$gr->name."</option>"; 
                            }                        
                        }                                                
                    ?>
                </select>                
            </td>
        </tr>
        
        <tr>
            <td>
                Статус:
            </td>
            <td>       
                <select name="selStatus" >
                    <option value="<?php echo DbRecordStatus::ACTIVE; ?>" <?php if($res->status == DbRecordStatus::ACTIVE) echo "selected=\"selected\""; ?> >Активный</option>
                    <option value="<?php echo DbRecordStatus::DELETED; ?>" <?php if($res->status == DbRecordStatus::DELETED) echo "selected=\"selected\""; ?> >Неактивный</option>
                </select>
            </td>
        </tr>
    </table>
    <input type="hidden" name="hdnGid" value="<?php echo $res->id; ?>" />
    <span class="error"><?php echo $error; ?></span>
    <input type="submit" value="Сохранить" />
</form>    
</div>

