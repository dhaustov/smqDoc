<div id="main">
    <?php if(!isset($_POST['selTid']) && !isset($_POST['hdnTid']) ) : ?>
        <form name="frmSelTpl" method="POST" action="<?php echo $frmAction; ?>" />
            <select name="selTid">
                <?php 
                    foreach ($allowedTemplates as $tpl)                    
                       echo "<option value=\"".$tpl->id."\"> ".$tpl->name." </option>";                                            
                ?>
            </select>
            <input type="submit" name="btnSbm" value="Создать" />
        </form>
    <?php else : ?>
        
        <?php if (!$res->id) :?>
            <h2>Создание нового документа</h2>
        <?php else :?>
           <h2>Редактировать документ</h2>
        <?php endif;?>
           
           <form name="frmDoc" method="POST" action="<?php echo $frmAction; ?>" >
               <table>                                  
                <?php
                 $i=0;
                 foreach($res->groupDocTempl->fieldsList as $field)
                 {
                     echo "<tr>";
                     echo "<td>".$field->name.":</td>";
                     echo "<td><input type=\"text\" id=\"txtVal$i\" name=\"txtVal$i\" value=\"".$res->fieldsList[$i]->GetValue()."\" /> </td> ";
                     echo "</tr>";
                     $i++;
                 }                 
                ?>
                </table>
                <span class="error"><?php echo $error; ?></span>
                <input type="submit" value="Сохранить" />
               
                <input type="hidden" name="hdnTid" value="<?php echo $res->groupDocTempl->id; ?>" />
                <input type="hidden" name="hdnDocID" value="<?php echo $res->id; ?>" />
           </form>        
           
     <?php endif; ?>
</div>

