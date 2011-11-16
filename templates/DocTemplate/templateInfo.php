<div id="main">
    <h2>Информация о шаблоне документа:</h2>

      
        Наименование шаблона: 
        <?php echo  $res->name; ?><br/>
        <b>Поля:</b>
        <table style="border: 1px solid black;">
            <tr>
                <th>
                    Имя поля
                </th>
                <th>
                    Тип поля
                </th>
                <th>
                    Вычислимое
                </th>
                <th>
                    Операция при вычислении
                </th>
                <th>
                    Ограниченное
                </th>
                <th>
                    Нижняя граница
                </th>
                <th>
                    Верхняя граница
                </th>
            </tr>
        <?php if($res->lstobjFields) foreach ($res->lstobjFields as $field) : ?>
            
            <tr>
                <td>
                    <?php echo $field->name; ?>
                </td>
                <td>
                    <?php /*echo $field->fieldType->name;*/ ?>                                
                </td>
                <td style="display:none">                                
                    <?php echo $field->isCalculated ? "Да" : "Нет"; ?>                                
                </td>
                <td>
                    <?php echo $field->isRestricted ? "Да" : "Нет"; ?>                                
                </td>
                <td>
                    <?php echo isset($field->minVal) ? $field->minVal : "---"; ?>
                </td>
                <td>
                    <?php echo isset($field->maxVal) ?  $field->maxVal : "---"; ?>
                </td>                           
            </tr>
        <?php endforeach; ?>        
    </table>
    <span class="error"><?php echo $error; ?></span>

</div>