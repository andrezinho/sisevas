<?php  
    include("../lib/helpers.php"); 
    include("../view/header_form.php");
?>

   
<form id="frm-conceptos" >
    <input type="hidden" name="controller" value="Concepto" />

    <input type="hidden" name="action" value="save" />
    
        <label for="idconcepto" class="labels">Codigo:</label>
            <input id="idconcepto" name="idconcepto" class="text ui-widget-content ui-corner-all" style=" width: 100px; text-align: left;" value="<?php echo $obj->idconcepto; ?>" readonly />
        <br/>
        
        <label for="descripcion" class="labels">Descripcion:</label>
            <input id="descripcion" maxlength="100" name="descripcion" onkeypress="return permite(event,'num_car');" class="text ui-widget-content ui-corner-all" style=" width: 350px; text-align: left;" value="<?php echo $obj->descripcion; ?>" />
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
