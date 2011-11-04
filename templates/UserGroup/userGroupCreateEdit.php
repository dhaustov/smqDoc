<script type="text/javascript">
    function AddNewTemplate()
    {
        var lst = document.getElementById("lstAllTemplates");
        var hdnCnt = document.getElementById("hdnNewTempCount");
        var hdnLastID = document.getElementById("hdnNewTempLastID");
        var divNewTemp = document.getElementById("divNewTemplates");
        
        var newID = +hdnLastID.value + 1;
        var newCnt = +hdnCnt.value + 1;
            
        var elem = document.createElement("input");
        elem.setAttribute("type", "hidden");
        elem.setAttribute("value", lst.value);
        elem.setAttribute("name", "hdnNewTemplate" + newID.toString());
        elem.setAttribute("id", "hdnNewTemplate" + newID.toString());
                
        var text = document.createElement("span");
        text.innerHTML = lst[lst.selectedIndex].innerHTML;
        text.setAttribute("style", "color: blue");
        
        divNewTemp.appendChild(document.createElement("br"));
        divNewTemp.appendChild(elem);
        divNewTemp.appendChild(text);
        
        hdnLastID.value = newID;
        hdnCnt.value = newCnt;
        
        //alert("new value: " + elem.value + " Last ID: " + hdnLastID.value + " new count: " +hdnCnt.value );
    }
</script>
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
        <?php if($res->id > 0) : ?>
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
        <?php endif; ?>
        
        <?php if($res->id > 0) : ?>
            <tr>
                <td>
                    Добавить шаблон документа:
                </td>
                <td>
                    <select name="lstAllTemplates" id="lstAllTemplates">
                      <?php 
                            if($lstDocTemplatesAll) 
                                foreach($lstDocTemplatesAll as $t) 
                                {
                                    echo "<option value='".$t->id."'>".$t->name."</option>";
                                }
                      ?>
                    </select>
                    <input type="button" id="btnAdd" onclick ="AddNewTemplate()" value="Добавить" />
                    <input type="hidden" id="hdnNewTempCount" name="hdnNewTempCount" value="0" />
                    <input type="hidden" id="hdnNewTempLastID" name="hdnNewTempLastID" value="0" />
                </td>
            </tr>            
        <?php endif; ?>
            
    </table>
    <input type="hidden" name="hdnGid" value="<?php echo $res->id; ?>" />
    <span class="error"><?php echo $error; ?></span>
    <input type="submit" value="Сохранить" />
</form>    
</div>


