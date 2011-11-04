<div id="main">
    <h2>Информация о группе:</h2>

    <table>
        <tr>
            <td>  
                Название группы:
            </td>
            <td>      
                <?php echo  $res->name; ?>
            </td>
        </tr>        
        <tr>
            <td>                
                Глава группы:
            </td>
            <td>                
                <?php echo $masterUser->surName." ".$masterUser->name." ".$masterUser->middleName." (".$masterUser->login.")"; ?>
            </td>
        </tr>
        <tr>
            <td>                
                Роль главы группы:
            </td>
            <td>                
                <?php echo $res->masterUserAccountRole; ?>
            </td>
        </tr>
        <tr>
            <td>    
                Родитеская группа: 
            </td>
            <td>                
                <?php echo $parentGroup->name; ?>
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
        <tr>
            <td>
                Шаблоны документов:
            </td>                    
            <td>
                <div id="divNewTemplates" style="border: 0px;" >
                    <?php if($lstDocTemplatesExists) 
                            foreach($lstDocTemplatesExists as $t) : 
                                echo $t->name." <br />";
                            endforeach; 
                        ?>
                </div>
            </td>
       </tr>  
    </table>
    <span class="error"><?php echo $error; ?></span>

</div>