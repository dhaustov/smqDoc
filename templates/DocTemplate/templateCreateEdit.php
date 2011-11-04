<div id="main">
    <script type="text/javascript">
        function Restricted(id)
        {        
            var lblMax = document.getElementById("lblMaxValue" + id);
            var lblMin = document.getElementById("lblMinValue" + id);
            
            if(lblMax.attributes["disabled"])
                {            
                    lblMax.removeAttribute("disabled");
                    lblMin.removeAttribute("disabled");
                }
            else
                {                
                    lblMax.setAttribute("disabled","disabled");
                    lblMin.setAttribute("disabled","disabled");                    
                }                    
        }
        
        function Calculated(id)
        {
            var selOper = document.getElementById("selOper" + id);
            if(selOper.attributes["disabled"])
                selOper.removeAttribute("disabled");
            else
                selOper.setAttribute("disabled", "disabled");
        }
        
        function AddNewField()
        {
            var lastNum = document.getElementById("lastFieldNum");
            var lastNumVal = lastNum.value;
            var newVal = +lastNumVal + 1;
            
            //Мазохизм....
            var rootDiv = document.getElementById("dFields");
            
            var div = document.createElement("div");
            div.setAttribute("id", "dF"+newVal);
            div.setAttribute("name", "dF"+newVal);
            
            var table = document.createElement("table");
            
            
            var tr1 = document.createElement("tr");
            var td1 = document.createElement("td");
            td1.innerHTML = "Имя поля:";            
            var td2 = document.createElement("td");
            var lblName = document.createElement("input");
            lblName.setAttribute("type", "text");
            lblName.setAttribute("name", "lblName"+newVal);
            lblName.setAttribute("id", "lblName"+newVal);
            td2.appendChild(lblName);
            
            tr1.appendChild(td1);
            tr1.appendChild(td2);
            
            var tr2 = document.createElement("tr");
            var td3 = document.createElement("td");
            td3.innerHTML = "Тип поля:";            
            var td4 = document.createElement("td");
            var selType = document.createElement("select");
            selType.setAttribute("name", "selFieldType"+newVal);
            selType.setAttribute("id", "selFieldType"+newVal);
            
            var strIDs = document.getElementById("arrFieldTypesIndexes").value;
            var strValues = document.getElementById("arrFieldTypesValues").value;
            
            var arrIDs = String(strIDs).split(",", 100);
            var arrValues = String(strValues).split(",", 100);
            
            for (var i=0; i<arrIDs.length; i++)
                {
                    var opt = document.createElement("option");
                    opt.setAttribute("value", arrIDs[i]);
                    opt.innerHTML = arrValues[i];
                    selType.appendChild(opt);
                }
            
            td4.appendChild(selType);
            
            tr2.appendChild(td3);
            tr2.appendChild(td4);
            
            var tr3 = document.createElement("tr");
            var td5 = document.createElement("td");
            td5.innerHTML = "Вычислимое:";
            var td6 = document.createElement("td");
            var chkCalc = document.createElement("input");
            chkCalc.setAttribute("type","checkbox");
            chkCalc.setAttribute("name","chkIsCalculated"+newVal);
            chkCalc.setAttribute("id","chkIsCalculated"+newVal);
            chkCalc.setAttribute("onclick", "Calculated("+newVal+")");
            td6.appendChild(chkCalc);
            
            tr3.appendChild(td5);
            tr3.appendChild(td6);
            
            var tr7 = document.createElement("tr");
            var td13 = document.createElement("td");
            td13.innerHTML = "Операция при вычислении:";            
            var td14 = document.createElement("td");
            var selType = document.createElement("select");
            selType.setAttribute("name", "selOper"+newVal);
            selType.setAttribute("id", "selOper"+newVal);
            selType.setAttribute("disabled", "disabled");
            
            var strIDs = document.getElementById("arrOperationsIndexes").value;
            var strValues = document.getElementById("arrOperationsValues").value;
            
            var arrIDs = String(strIDs).split(",", 100);
            var arrValues = String(strValues).split(",", 100);
            
            for (var i=0; i<arrIDs.length; i++)
                {
                    var opt = document.createElement("option");
                    opt.setAttribute("value", arrIDs[i]);
                    opt.innerHTML = arrValues[i];
                    selType.appendChild(opt);
                }
            
            td14.appendChild(selType);
            
            tr7.appendChild(td13);
            tr7.appendChild(td14);
            
            var tr4 = document.createElement("tr");
            var td7 = document.createElement("td");
            td7.innerHTML = "Ограниченное:";
            var td8 = document.createElement("td");
            var chkRest = document.createElement("input");
            chkRest.setAttribute("type","checkbox");
            chkRest.setAttribute("name","chkIsRestricted"+newVal);
            chkRest.setAttribute("id","chkIsRestricted"+newVal);
            chkRest.setAttribute("onclick", "Restricted("+newVal+")");
            td8.appendChild(chkRest);
            
            tr4.appendChild(td7);
            tr4.appendChild(td8);
            
            var tr5 = document.createElement("tr");
            var td9 = document.createElement("td");
            td9.innerHTML = "Нижняя граница";
            var td10 = document.createElement("td");
            var lblMin = document.createElement("input");
            lblMin.setAttribute("type", "text");
            lblMin.setAttribute("name", "lblMinValue"+newVal);
            lblMin.setAttribute("id", "lblMinValue"+newVal);
            lblMin.setAttribute("disabled", "disabled");
            td10.appendChild(lblMin);
            
            tr5.appendChild(td9);
            tr5.appendChild(td10);
            
            var tr6 = document.createElement("tr");
            var td11 = document.createElement("td");
            td11.innerHTML = "Верхняя граница";
            var td12 = document.createElement("td");
            var lblMax = document.createElement("input");
            lblMax.setAttribute("type", "text");
            lblMax.setAttribute("name", "lblMaxValue"+newVal);
            lblMax.setAttribute("id", "lblMaxValue"+newVal);
            lblMax.setAttribute("disabled", "disabled");
            td12.appendChild(lblMax);
            
            tr6.appendChild(td11);
            tr6.appendChild(td12);
            
            var hdnID = document.createElement("input");
            hdnID.setAttribute("type", "hidden");
            hdnID.setAttribute("name", "hdnId"+newVal);
            hdnID.setAttribute("id", "hdnId"+newVal);
            div.appendChild(hdnID);
            
            table.appendChild(tr1);
            table.appendChild(tr2);
            table.appendChild(tr3);
            table.appendChild(tr7);
            table.appendChild(tr4);
            table.appendChild(tr5);
            table.appendChild(tr6);
            
                                    
            div.appendChild(table);
            rootDiv.appendChild(div);
            //инкрементим общее число полей и номер последнего
            var totalCount= document.getElementById("totalFieldsCount");
            var totalCountVal = document.getElementById("totalFieldsCount").value;
            totalCount.value = +totalCountVal + 1;  
            lastNum.value = newVal;
        }
    </script>
<h2>Создание нового шаблона:</h2>
<form name="frmNewTemplate" method="POST" action="<?php echo $frmAction; ?>" />
    <table>
        <tr>
            <td>  
                Название Шаблона:
            </td>
            <td>      
                <input type="text" name="lblName" value="<?php echo $res->name; ?>" />
            </td>
        </tr>
        <tr>
            <td colspan="2">
        <?php if(!$res->fieldsList) : ?>
        <!-- Создание нового шаблона - полей нет -->        
            <div id="dFields" name="dFields" >
                <div id="dF1" name="dF1"> <!--Первый элемент -->
                    <table>
                        <tr>
                            <td>
                                Имя поля:
                            </td>
                            <td>
                                <input type="Text" id="lblName1" name="lblName1" value="" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Тип поля:
                            </td>
                            <td>
                                <select id="selFieldType1" name="selFieldType1">
                                    <?php if($lstFieldTypes) 
                                              foreach($lstFieldTypes as $type)                                               
                                                    echo "<option value=".$type->id." >".$type->name."</option>";                                               
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Вычислимое:
                            </td>
                            <td>
                                <input type="checkbox" id="chkIsCalculated1" name="chkIsCalculated1" onclick="Calculated(1)" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Операция при вычислении:
                            </td>
                            <td>
                                <select id="selOper1" name="selOper1" disabled="disabled">
                                    <?php if($lstOperations) 
                                              foreach($lstOperations as $oper)                                               
                                                    echo "<option value=".$oper->id." >".$oper->name."</option>";                                               
                                    ?>
                                </select>
                            </td>
                        </tr>
                        
                        <tr>
                            <td>
                                Ограниченное:
                            </td>
                            
                            <td>
                                <input type="checkbox" id="chkIsRestricted1" name="chkIsRestricted1" onclick="Restricted(1)" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Нижняя граница:
                            </td>
                            <td>
                                <input type="Text" id="lblMinValue1" name="lblMinValue1" disabled="disabled" value="" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Верхняя граница:
                            </td>
                            <td>
                                <input type="Text" id="lblMaxValue1" name="lblMaxValue1" disabled="disabled" value="" />
                            </td>                                                        
                    </table>
                    <input type="hidden" id="hdnId1" name="hdnId1" value="" />
                </div>                
            </div>
        <?php else : ?>
        <!-- Редактирование шаблона - поля есть -->        
             <div id="dFields" name="dFields" >
                <?php $i=1; foreach ($res->fieldsList as $field) : ?>
                 <div id="dF<?php echo $i; ?>" name="dF<?php echo $i; ?>"> 
                    <table>
                        <tr>
                            <td>
                                Имя поля:
                            </td>
                            <td>
                                <input type="Text" 
                                       id="lblName<?php echo $i; ?>" 
                                       name="lblName<?php echo $i; ?>" 
                                       value="<?php echo $field->name; ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Тип поля:
                            </td>
                            <td>
                                <select id="selFieldType<?php echo $i; ?>" name="selFieldType<?php echo $i; ?>">
                                    <?php if($lstFieldTypes) 
                                              foreach($lstFieldTypes as $type)        
                                              {
                                                $selected = "";
                                                if(isset($field->fieldType))
                                                   if($field->fieldType->id == $type->id)
                                                      $selected = " selected=\"selected\" ";
                                                   
                                                echo "<option value=".$type->id." $selected >".$type->name."</option>";                                               
                                              }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Вычислимое:
                            </td>
                            <td>
                                <input type="checkbox" id="chkIsCalculated<?php echo $i; ?>" 
                                       name="chkIsCalculated<?php echo $i; ?>" 
                                       onclick="Calculated(<?php echo $i; ?>)" 
                                       <?php 
                                            if(isset($field->isCalculated) && $field->isCalculated)
                                               echo " checked=\"checked\" ";
                                       ?>
                                />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Операция при вычислении:
                            </td>
                            <td>
                                <select id="selOper<?php echo $i; ?>" 
                                        name="selOper<?php echo $i; ?>" 
                                        <?php 
                                            if(!isset($field->isCalculated) || 
                                               ( isset($field->isCalculated) &&  !$field->isCalculated) )
                                               echo " disabled=\"disabled\" ";
                                        ?>
                                        >
                                    <?php if($lstOperations) 
                                        foreach($lstOperations as $oper)                                               
                                        {
                                           $selected = "";
                                            if(isset($field->operation))
                                               if($field->operation->id == $oper->id)
                                                  $selected = " selected=\"selected\" ";

                                           echo "<option value=".$oper->id." $selected >".$oper->name."</option>";                                               
                                        }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        
                        <tr>
                            <td>
                                Ограниченное:
                            </td>
                            
                            <td>
                                <input type="checkbox" 
                                       id="chkIsRestricted<?php echo $i; ?>" 
                                       name="chkIsRestricted<?php echo $i; ?>" 
                                       onclick="Restricted(<?php echo $i; ?>)" 
                                       <?php 
                                            if(isset($field->isRestricted) && $field->isRestricted)
                                               echo " checked=\"checked\" ";
                                       ?>
                                />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Нижняя граница:
                            </td>
                            <td>
                                <input type="Text" 
                                       id="lblMinValue<?php echo $i; ?>" 
                                       name="lblMinValue<?php echo $i; ?>" 
                                        <?php 
                                            if(!isset($field->isRestricted) || 
                                               ( isset($field->isRestricted) &&  !$field->isRestricted) )
                                                    echo " disabled=\"disabled\" ";
                                        ?>
                                       value='<?php echo $field->minVal; ?>' />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Верхняя граница:
                            </td>
                            <td>
                                <input type="Text" 
                                       id="lblMaxValue<?php echo $i; ?>" 
                                       name="lblMaxValue<?php echo $i; ?>" 
                                       <?php 
                                            if(!isset($field->isRestricted) || 
                                               ( isset($field->isRestricted) &&  !$field->isRestricted) )
                                                    echo " disabled=\"disabled\" ";
                                        ?>
                                       value='<?php echo $field->maxVal; ?>' />
                            </td>   
                        </tr>
                    </table>
                    <input type="hidden" 
                           id="hdnId<?php echo $i; ?>" 
                           name="hdnId<?php echo $i; ?>" 
                           value='<?php echo $field->id; ?>' />
                </div>    
                <?php $i++; endforeach; ?>
            </div>            
        <?php endif; ?>
                <br />
                <a href="javascript:void(0)" onclick="AddNewField()">Добавить поле</a>
            </td>
        </tr>
    </table>
    <input type="hidden" name="hdnTid" value="<?php echo $res->id; ?>" />
    
    <!--для добавления новых полей -->
    <input type="hidden" name="lastFieldNum" id="lastFieldNum" value='<?php if($res->fieldsList) echo count($res->fieldsList); else echo "1"; ?>' />
    <input type="hidden" name="totalFieldsCount" id="totalFieldsCount" value='<?php if($res->fieldsList) echo count($res->fieldsList); else echo "1"; ?>' />
     
    
    <!-- FIXIT:заменить на нормальный сериализованный массив! -->
    <input type="hidden" name="arrFieldTypesIndexes" id="arrFieldTypesIndexes" value='<?php $i=0; if($lstFieldTypes) foreach($lstFieldTypes as $item) {  echo $item->id; if($i<count($lstFieldTypes) - 1) echo ","; $i++; } ?>' />
    <input type="hidden" name="arrFieldTypesValues" id="arrFieldTypesValues" value='<?php $i=0; if($lstFieldTypes) foreach($lstFieldTypes as $item) {  echo $item->name; if($i<count($lstFieldTypes) - 1) echo ","; $i++; } ?>' />
    
    <input type="hidden" name="arrOperationsIndexes" id="arrOperationsIndexes" value='<?php $i=0; if($lstOperations) foreach($lstOperations as $item) {  echo $item->id; if($i<count($lstOperations) - 1) echo ","; $i++; } ?>' />
    <input type="hidden" name="arrOperationsValues" id="arrOperationsValues" value='<?php $i=0; if($lstOperations) foreach($lstOperations as $item) {  echo $item->name; if($i<count($lstOperations) - 1) echo ","; $i++; } ?>' />
    
    <span class="error"><?php echo $error; ?></span>
    <input type="submit" value="Сохранить" />
</form>    
</div>

