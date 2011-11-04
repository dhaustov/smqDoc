<div id="main">
    <h2>Список групп пользователей:</h2>
    <form name="frmUserGroupList" method="POST"  action="<?php echo $frmAction; ?>" />
    <table style="border: 1px solid black;">
        <th>
            Наименование группы
        </th>
        <th>
            Глава группы
        </th>
        <th>
            Родительская группа
        </th>
        <th>
            Операции
        </th>
        <?php   $i=0;
                if($res) foreach ($res as $group) : ?>
            <tr>
                <td><?php echo "<a href=\"index.php?module=".Modules::USERGROUPS."&action=".Actions::SHOW."&id=".$group->id."\">".$group->name."</a>"; ?></td>
                <td><?php if(isset($lstGroupMasterUsers[$i])) echo $lstGroupMasterUsers[$i]->surName." ".$lstGroupMasterUsers[$i]->name." ".$lstGroupMasterUsers[$i]->middleName;?></td>
                <td><?php if(isset($lstGroupParents[$i])) echo $lstGroupParents[$i]->name; ?></td>
                <td><?php echo "<a href=\"index.php?module=".Modules::USERGROUPS."&action=".Actions::EDIT."&id=".$group->id."\">Редактировать</a>"; ?></td>
            </tr>
        <?php   $i++;
                endforeach; ?>
    </table>
    <div id="paging">
        Размер страницы:        
        <select name ="pageSize" >            
            <option value="0" selected ="selected">Все пользователи</option>
            <option value="5" <?php if(isset($_REQUEST['pageSize']) && $_REQUEST['pageSize']=="5") echo "selected=\"selected\"" ?> >5 пользователей</option>
            <option value="10" <?php if(isset($_REQUEST['pageSize']) && $_REQUEST['pageSize']=="10") echo "selected=\"selected\"" ?> >10 пользователей</option>
            <option value="20" <?php if(isset($_REQUEST['pageSize']) && $_REQUEST['pageSize']=="20") echo "selected=\"selected\"" ?> >20 пользователей</option>
        </select> 
        <input type="submit" value="Показать" />
        <br />
        <?php if(isset($_REQUEST["pageSize"]) && $_REQUEST["pageSize"] > 0 ) : ?>
            Страницы: 
                <?php 
                   for ($i=0;$i<=$totalItems/$_REQUEST["pageSize"];$i++)
                   {
                        //TODO: добавить атрибут css класс для активной ссылки в $active
                        if( ( isset($_REQUEST["pageNum"]) && $_REQUEST["pageNum"] == $i ) ||
                            ( !isset($_REQUEST["pageNum"]) && $i==0 )
                          )
                            $active = " style='color:blue; text-decoration: none; ' ";
                        else
                            $active = " style='color:blue;' ";
                        
                        echo "<a href='index.php?module=".Modules::USERGROUPS.
                             "&action=".Actions::SHOWLIST.
                             "&pageNum=".$i.
                             "&pageSize=".$_REQUEST['pageSize']."' $active > ".($i+1)." </a>";
                   }
                ?>
        <?php endif; ?>
    </div>
</form>
</div>

