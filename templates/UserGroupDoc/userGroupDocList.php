<div id="main">
    <h2>Список документов пользователя:</h2>
    <form name="frmUserGroupDocList" method="POST"  action="<?php echo $frmAction; ?>" />
    <table style="border: 1px solid black;">
        <th>
            Шаблон документа
        </th>
        <th>
            Имя пользователя
        </th>
        <th>
            Группа
        </th>
        <th>
            Дата Создания
        </th>
        <th>
            Операции
        </th>
        <?php   $i=0;
                if($res) foreach ($res as $doc) : ?>
            <tr>
                <td><?php echo "<a href=\"index.php?module=".Modules::DOCUMENTS."&action=".Actions::SHOW."&id=".$doc->id."\">".$doc->groupDocTempl->name."</a>"; ?></td>
                <td><?php  echo $doc->author->surName." ".$doc->author->name." ".$doc->author->middleName;?></td>
                <td><?php  echo $doc->group->name; ?></td>
                <td><?php echo $doc->dateCreated; ?></td>
                <td><?php echo "<a href=\"index.php?module=".Modules::DOCUMENTS."&action=".Actions::EDIT."&id=".$doc->id."\">Редактировать</a>"; ?></td>
            </tr>
        <?php   $i++;
                endforeach; ?>
    </table>
    <div id="paging">
        Размер страницы:        
        <select name ="pageSize" >            
            <option value="0" selected ="selected">Все документы</option>
            <option value="5" <?php if(isset($_REQUEST['pageSize']) && $_REQUEST['pageSize']=="5") echo "selected=\"selected\"" ?> >5 документов</option>
            <option value="10" <?php if(isset($_REQUEST['pageSize']) && $_REQUEST['pageSize']=="10") echo "selected=\"selected\"" ?> >10 документов</option>
            <option value="20" <?php if(isset($_REQUEST['pageSize']) && $_REQUEST['pageSize']=="20") echo "selected=\"selected\"" ?> >20 документов</option>
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