<?php  
    include("../lib/helpers.php"); 
    include("../view/header_form.php");
    
    $Hora_server = date('H:i:s');
?>

   
<form id="frm_val" >
    <input type="hidden" name="controller" value="valoresemp" />

    <input type="hidden" name="action" value="save" />
    <input type="hidden" id="idvaloresemp" name="idvaloresemp" value="<?php echo $obj->idvaloresemp; ?>" />
            
        
        <label for="fec" class="labels">Valor:</label>
        <input type="text" name="valor" id="valor" value="<?php echo $obj->valor; ?>" style=" width: 400px; text-align: left;" class="text ui-widget-content ui-corner-all" />
        <br/>
        
        <label for="descripcion" class="labels">Descripcion:</label>
        <textarea name="descripcion" id="descripcion" style="width: 80%; margin-left:16%;" class="text ui-widget-content ui-corner-all" cols="80" rows="6"><?php echo $obj->descripcion; ?></textarea>
        
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
