<?php  include("../lib/helpers.php"); 
       include("../view/header_form.php");
?>

   
<form id="frm" >
    <input type="hidden" name="controller" value="Innovacion" />

    <input type="hidden" name="action" value="save" />
    
        <label for="idinnovacion" class="labels">Codigo:</label>
        <input id="idinnovacion" name="idinnovacion" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->idinnovacion; ?>" readonly />
        <br/>
        
        <label for="idinnovacion" class="labels">Personal:</label>
        <?php $personal; ?>
        <br/>
        <label for="descripcion" class="labels">Descripcion:</label>
        <textarea name="descripcion" id="descripcion" style="width: 80%; margin-left:16%;" class="text ui-widget-content ui-corner-all" cols="80" rows="6"></textarea>
        <br/>
        
        <label for="estado" class="labels">Activo:</label>
                <?php                   
                    if($obj->estado==1 || $obj->estado==0)
                            {
                             if($obj->estado==1){$rep=1;}
                                else {$rep=0;}
                            }
                     else {$rep = 1;}                    
                     activo('activo',$rep);
                ?>     

</form>
