<?php  include("../lib/helpers.php"); 
       include("../view/header_form.php");
?>
   
<form id="frm_lineaaccion" >
    <fieldset class="ui-corner-all" style="padding: 2px 10px 7px">
        <input type="hidden" name="controller" value="lineaaccion" />
        <input type="hidden" name="action" value="save" />
    
        <input type="hidden" id="idlineaaccion" name="idlineaaccion" value="<?php echo $obj->idlineaaccion; ?>" />
                
        <label for="descripcion" class="labels">Descripcion:</label>
        <input id="descripcion" maxlength="100" name="descripcion" onkeypress="return permite(event,'car');" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->descripcion; ?>" />
        <br />
        
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
    </fieldset>

</form>
