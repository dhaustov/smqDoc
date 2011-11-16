<div id="main">
    <h2>Список шаблонов документов:</h2>
    <form name="frmUserList" method="POST" action="<?php echo $frmAction; ?>" />
    <table style="border: 1px solid black;">
        <th>
            Наименование шаблона
        </th>    
        <th>
            Количество полей
        </th>   
        <th>
            Операции
        </th>
        <?php if($res) foreach ($res as $template): if($template): ?>
            <tr>
                <td><?php echo "<a href=\"index.php?module=".Modules::DOCTEMPLATES."&action=".Actions::SHOW."&id=".$template->id."\">".$template->name."</a>"; ?></td>                
                <td><?php  echo count($template->lstobjFields)?></td>
                <td><?php echo "<a href=\"index.php?module=".Modules::DOCTEMPLATES."&action=".Actions::EDIT."&id=".$template->id."\">Редактировать</a>"; ?></td>
            </tr>
        <?php endif; endforeach; ?>
    </table>
    <div id="paging">
        Размер страницы:        
        <select name ="pageSize" >            
            <option value="0" selected ="selected">Все шаблоны</option>
            <option value="5" <?php if(isset($_REQUEST['pageSize']) && $_REQUEST['pageSize']=="5") echo "selected=\"selected\"" ?> >5 документов</option>
            <option value="10" <?php if(isset($_REQUEST['pageSize']) && $_REQUEST['pageSize']=="10") echo "selected=\"selected\"" ?> >10 документов</option>
            <option value="20" <?php if(isset($_REQUEST['pageSize']) && $_REQUEST['pageSize']=="20") echo "selected=\"selected\"" ?> >20 документов</option>
        </select> 
        <input type="submit" value="Показать" />
        <br />
        <?php if(isset($_REQUEST["pageSize"]) && $_REQUEST["pageSize"] > 0 ) : ?>
            Страницы: 
                <?php 
                   for ($i=0;$i<= $totalItems/$_REQUEST["pageSize"];$i++)
                   {
                        //TODO: добавить атрибут css класс для активной ссылки в $active
                        if( ( isset($_REQUEST["pageNum"]) && $_REQUEST["pageNum"] == $i ) ||
                            ( !isset($_REQUEST["pageNum"]) && $i==0 )
                          )
                            $active = " style='color:blue; text-decoration: none; ' ";
                        else
                            $active = " style='color:blue;' ";
                        
                        echo "<a href='index.php?module=".Modules::DOCTEMPLATES.
                             "&action=".Actions::SHOWLIST.
                             "&pageNum=".$i.
                             "&pageSize=".$_REQUEST['pageSize']."' $active > ".($i+1)." </a>";
                   }
                ?>
        <?php endif; ?>
    </div>
</form>
</div>

