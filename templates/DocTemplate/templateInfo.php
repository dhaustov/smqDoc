<div id="main">
    <h2>Информация о шаблоне документа:</h2>

    <table>
        <tr>
            <td>  
                Наименование:
            </td>
            <td>      
                <?php echo  $res->name; ?>
            </td>
        </tr>    
        <tr>
            <td colspan="2"></td>
        </tr>
        <?php if($res->fieldsList) foreach ($res->fieldsList as $field) : ?>
            <tr>
                <td>
                    Имя поля:
                </td>
                <td>
                    <?php echo $field->name; ?>
                </td>
            </tr>
            <tr>
                <td>
                    Тип поля:
                </td>
                <td>
                    <?php echo $field->fieldType->name; ?>                                
                </td>
            </tr>
            <tr>
                <td>
                    Вычислимое:
                </td>
                <td>                                
                    <?php echo $field->isCalculated ? "Да" : "Нет"; ?>                                
                </td>
            </tr>
            <tr>
                <td>
                    Операция при вычислении:
                </td>
                <td>
                    <?php echo isset($field->operation->id) ? $field->operation->name : "---"; ?>                                
                </td>
            </tr>                       
            <tr>
                <td>
                    Ограниченное:
                </td>

                <td>
                    <?php echo $field->isRestricted ? "Да" : "Нет"; ?>                                
                </td>
            </tr>
            <tr>
                <td>
                    Нижняя граница:
                </td>
                <td>
                    <?php echo isset($field->minVal) ? $field->minVal : "---"; ?>
                </td>
            </tr>
            <tr>
                <td>
                    Верхняя граница:
                </td>
                <td>
                    <?php echo isset($field->maxVal) ?  $field->maxVal : "---"; ?>
                </td>                           
            </tr>
            <tr>
                <td colspan="2"></td>
            </tr>
        <?php endforeach; ?>        
    </table>
    <span class="error"><?php echo $error; ?></span>

</div>