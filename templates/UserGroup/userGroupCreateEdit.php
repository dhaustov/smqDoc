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
        text.innerHTML = "Тип шаблона: " + lst[lst.selectedIndex].innerHTML + " (<a href='javascript:void(0);' onClick = 'DeleteNewTemplate(\"divTpl"+newID+"\")'>удалить) ";
        text.setAttribute("style", "color: blue");
        
        var name = document.createElement("input");
        name.setAttribute("type", "text");
        name.setAttribute("name", "newTemplateName" + newID.toString());
        name.setAttribute("id", "newTemplateName" + newID.toString());
        var txtName = document.createElement("span");
        txtName.innerHTML = "Название: ";
        
        var sdate = document.createElement("input");
        sdate.setAttribute("type", "text");
        sdate.setAttribute("name", "newTemplateStart" + newID.toString());
        sdate.setAttribute("id", "newTemplateStart" + newID.toString());
        var txtSDate = document.createElement("span");
        txtSDate.innerHTML = "Дата начала заполнения (ГГГГ-ММ-ДД): ";
        
        var edate = document.createElement("input");
        edate.setAttribute("type", "text");
        edate.setAttribute("name", "newTemplateEnd" + newID.toString());
        edate.setAttribute("id", "newTemplateEnd" + newID.toString());
        var txtEDate = document.createElement("span");
        txtEDate.innerHTML = "Дата окончания заполнения (ГГГГ-ММ-ДД): ";
        
        var outerDiv = document.createElement("div");
        outerDiv.setAttribute("id", "divTpl"+newID);
        outerDiv.setAttribute("style", "border: 1px dotted black; padding: 5px;");
        
        outerDiv.appendChild(elem);
        outerDiv.appendChild(text);
        outerDiv.appendChild(document.createElement("br"));
        outerDiv.appendChild(txtName);
        outerDiv.appendChild(document.createElement("br"));
        outerDiv.appendChild(name);
        outerDiv.appendChild(document.createElement("br"));
        outerDiv.appendChild(txtSDate);
        outerDiv.appendChild(document.createElement("br"));
        outerDiv.appendChild(sdate);
        outerDiv.appendChild(document.createElement("br"));        
        outerDiv.appendChild(txtEDate);
        outerDiv.appendChild(document.createElement("br"));
        outerDiv.appendChild(edate);
        
        divNewTemp.appendChild(outerDiv);
        divNewTemp.appendChild(document.createElement("br"));
        
        hdnLastID.value = newID;
        hdnCnt.value = newCnt;                
    }
    
    function DeleteNewTemplate(id)
    {      
        if( !confirm("Вы действительно хотите удалить шаблон?") )
            return false;
        
        if(document.getElementById(id))
            {
                var divTemplates = document.getElementById("divNewTemplates");                
                var child = document.getElementById(id);
                
                divTemplates.removeChild(child);
                return true;
            }
        return false;
    }
    
    function DeleteExistingTemplate(idTemplate)
    {
        if( !confirm("Вы действительно хотеите удалить шаблон?") )
            return false;
        
        var divTemplates = document.getElementById("divNewTemplates");                
        var divOldTpl = document.getElementById("divOldTpl"+idTemplate);
        if(divOldTpl)
        {            
            divTemplates.removeChild(divOldTpl);            
            return true;
        }
        return false;        
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
            <tr>
                <td>
                    Шаблоны документов:
                </td>                    
                <td>
                    <div id="divNewTemplates" style="border: 0px;" >
                        <?php if($lstDocTemplatesExists) 
                              { 
                                    $i=1;
                                    foreach($lstDocTemplatesExists as $t) : 
                                        /* @var $t UserGroup_DocTemplates */
                                        echo @"<div id=\"divOldTpl$i\" style=\"border: 1px solid black; padding: 5px;\"> 
                                                    Тип шаблона: ".$t->name." 
                                                    (<a href=\"javascript:void(0);\" onClick=\"DeleteExistingTemplate('$i')\"  >удалить</a>)
                                                    <br />
                                                    Название:
                                                    <br />
                                                    <input type=\"text\" name = \"oldTemplateName$i\" value=\"".$t->name."\" />
                                                    <br />
                                                    Дата начала заполнения (ГГГГ-ММ-ДД):
                                                    <br />
                                                    <input type=\"text\" name = \"oldTemplateStart$i\" value=\"".$t->startDate."\" />
                                                    <br />
                                                    Дата окончания заполнения (ГГГГ-ММ-ДД):
                                                    <br />
                                                    <input type=\"text\" name = \"oldTemplateEnd$i\" value=\"".$t->endDate."\" />

                                                    <input type=\"hidden\" name = \"hdnOldTemplate$i\" value=\"".$t->idDocTemplate."\" />
                                                    <input type=\"hidden\" name = \"hdnOldTemplateID$i\" value=\"".$t->id."\" />
                                               </div>
                                               <br />";
                                        $i++;
                                    endforeach;
                              }
                            ?>
                    </div>
                </td>
            </tr>  
 
            <tr>
                <td>
                    Добавить шаблон документа:
                </td>
                <td>
                    <select name="lstAllTemplates" id="lstAllTemplates">
                      <?php 
                            if($lstDocTemplatesAll) 
                                foreach($lstDocTemplatesAll as $t)                                 
                                    echo "<option value='".$t->id."'>".$t->name."</option>";                                
                      ?>
                    </select>
                    <input type="button" id="btnAdd" onclick ="AddNewTemplate()" value="Добавить" />
                    <input type="hidden" id="hdnNewTempCount" name="hdnNewTempCount" value="0" />
                    <input type="hidden" id="hdnNewTempLastID" name="hdnNewTempLastID" value="0" />                    
                    <input type="hidden" id="hdnOldTempCount" name="hdnOldTempCount" value="<?php echo count($lstDocTemplatesExists); ?>" />
                </td>
            </tr>                                
    </table>
    <input type="hidden" name="hdnGid" value="<?php echo $res->id; ?>" />
    <span class="error"><?php echo $error; ?></span>
    <input type="submit" value="Сохранить" />
</form>    
</div>


