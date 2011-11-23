<form name="frmDashboard" method="POST" action="<?php echo $frmAction; ?>" />
<?php
    echo "Добрый день ".LoginHelper::GetCurrentUserName();
    if($res)
    {
        if(count($res) == 1)
            LoginHelper::SetCurrentUserGroupId ($res[0]->id);
        else
        {
            if(!LoginHelper::GetCurrentUserGroupId())
                {
                    LoginHelper::SetCurrentUserGroupId ($res[0]->id);
                }
            ?>
            <br/>Текущая роль <select id="currGroupId" name="currGroupId">;
            <?php
            foreach($res as $group)
            {
                $seld = ($group->id == LoginHelper::GetCurrentUserGroupId()) ? "SELECTED" : "";
                echo "<option value=".$group->id." ".$seld.">".$group->masterUserAccountRole;
            }
            ?>
            </select>
            <input type="submit" value="Изменить"/>
</form>
            <?php
        }
    }
    
?>
