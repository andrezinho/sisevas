<?php  include("../lib/helpers.php"); 
       include("../view/header_form.php");
?>
   
<form id="frm_area" >
    <input type="hidden" name="controller" value="medioverificacion" />

    <input type="hidden" name="action" value="save" />
    <input type="hidden" id="idmediosverificacion" name="idmediosverificacion" value="<?php echo $obj->idmediosverificacion; ?>" />
                
    <label for="descripcion" class="labels">Descripcion:</label><br/>
        <!--<input id="descripcion" name="descripcion" class="text ui-widget-content ui-corner-all" style=" width: 500px; text-align: left;" value="<?php echo $obj->descripcion; ?>" />-->
        <textarea name="descripcion" id="descripcion" style="width: 80%; margin-left:20%;" class="text ui-widget-content ui-corner-all" cols="70" rows="3"><?php echo $obj->descripcion; ?></textarea>
        <br>
        
        <label for="estado" class="labels">Activo:</label>
        <div id="estados" style="display:inline">
            <?php                   
                if($obj->estado==1 || $obj->estado==0)
                {
                    if($obj->estado==1){$rep=1;}
                    else {$rep=0;}
                }
                else {$rep = 1;}                    
                    activo('activo',$rep);
            ?>
        </div>     

</form>
