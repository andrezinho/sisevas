<?php  include("../lib/helpers.php"); 
       include("../view/header_form.php");
?>
  
<form id="frm_objcap" >
    <input type="hidden" name="controller" value="objetivoscap" />

    <input type="hidden" name="action" value="save" />
    <input id="idobejtivoscap" name="idobejtivoscap"  value="<?php echo $obj->idobejtivoscap; ?>" type="hidden" />       
        
        <label for="descripcion" class="labels">Descripcion:</label>
        <input id="descripcion" name="descripcion" onkeypress="return permite(event,'num_car');" class="text ui-widget-content ui-corner-all" style=" width: 400px; text-align: left;" value="<?php echo $obj->descripcion; ?>" />
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

</form>
