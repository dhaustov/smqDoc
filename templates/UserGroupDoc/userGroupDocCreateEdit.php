<div id="main">
    <?php if(!isset($_POST['selTid']) && !isset($_POST['hdnTid'])  && !isset($_GET['id']) ) : ?>
        <form name="frmSelTpl" method="POST" action="<?php echo $frmAction; ?>" />
            <select name="selTid">
                <?php 
                    
                    foreach ($allowedTemplates as $tpl)                    
                    {
                        /* @var  $tpl UserGroup_DocTemplates */
                       echo "<option value=\"".$tpl->id."\"> ".$tpl->name." </option>";                                            
                    }
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
                 //foreach($res->objGroupDocTempl->fieldsList as $field)
                 //foreach($res->objGroupDocTempl->lstobjFields as $field)
                 /* @var $res UserGroupDoc */
                 // lstObjDocField
                 //echo "count:".count($res->objDocTemplate->lstobjFields);
                 foreach($res->objDocTemplate->lstobjFields as $field)
                 {
                     echo "<tr>";
                     echo "<td>".$field->name.":</td>";
                     echo "<td><input type=\"text\" id=\"txtVal$i\" name=\"txtVal$i\" value=\"".$res->lstObjDocField[$i]->GetValue()."\" /> </td> ";
                     echo "</tr>";
                     $i++;
                 }                 
                ?>
                </table>
                <span class="error"><?php echo $error; ?></span>
                <input type="submit" value="Сохранить" />
               
                <input type="hidden" name="hdnTid" value="<?php echo $res->objGroupDocTempl->id; ?>" />
                <input type="hidden" name="hdnDocID" value="<?php echo $res->id; ?>" />
           </form>        
           
     <?php endif; ?>
</div>

