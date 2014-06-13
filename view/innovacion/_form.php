<?php  
    include("../lib/helpers.php"); 
    include("../view/header_form.php");
    
    $Hora_server = date('H:i:s');
?>

   
<form id="frm_innovacion" >
    <input type="hidden" name="controller" value="Innovacion" />

    <input type="hidden" name="action" value="save" />
    
        <input type="hidden" id="idinnovacion" name="idinnovacion" value="<?php echo $obj->idinnovacion; ?>" />
        <input type="hidden" name="horain" value="<?php echo $Hora_server; ?>" />
           
        <label for="idinnovacion" class="labels">Personal:</label>
        <?php echo $personal; ?>
        <br/>
        <label for="descripcion" class="labels">Descripcion:</label>
        <textarea name="descripcion" id="descripcion" style="width: 80%; margin-left:16%;" class="text ui-widget-content ui-corner-all" cols="80" rows="6"><?php echo $obj->descripcion; ?></textarea>
        <br/>
        <label for="fec" class="labels">Palabras Clav.:</label>
        <input type="text" name="palabraclave" id="palabraclave" value="<?php echo $obj->palabraclave; ?>" style=" width: 400px; text-align: left;" class="text ui-widget-content ui-corner-all" />
        
        <br />
        <label for="fec" class="labels">Fecha Innov.:</label>
        <input type="text" name="fechain" id="fechain" value="<?php if($obj->fechain!=""){echo fdate($obj->fechain,'ES');} else {echo date('d/m/Y');} ?>" class="text ui-widget-content ui-corner-all" />
                 
</form>
