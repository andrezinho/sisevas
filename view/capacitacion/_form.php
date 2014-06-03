<?php  include("../lib/helpers.php"); 
       include("../view/header_form.php");
?>
   
<form id="frm_cap" >
    <input type="hidden" name="controller" value="capacitacion" />
    <input type="hidden" name="action" value="save" />
    <input type="hidden" id="idcapacitacion" name="idcapacitacion" value="<?php echo $obj->idcapacitacion; ?>" />
    
    <label for="fuente" class="labeless">Fuente de cap.:</label> 
    <?php echo $fuente; ?>
    
    <label for="eje" class="labeless">Eje de capac.:</label> 
    <?php echo $eje; ?>
    <br />
      
    <label for="tem" class="labeless">Tema:</label>
    <input id="tema" name="tema" onkeypress="return permite(event,'num_car');" class="text ui-widget-content ui-corner-all" style=" width: 520px; text-align: left;" value="<?php echo $obj->tema; ?>" />
    <br />
    
    <label for="objemp" class="labeless">Objetivo de emp.:</label> 
    <?php echo $objemp; ?>
    <a class="nuevo" title="Nuevo Registro"><span class="box-boton boton-new"></span></a>
    
    <label for="objcap" class="labeless">Objetivo de capac.:</label> 
    <?php echo $objcap; ?>
    <br />
    
    <label for="ref" class="labeless">Referencia Biblio.:</label><br />
    <textarea name="referencias" id="referencias" style="width: 70%; margin-left:16%;" class="text ui-widget-content ui-corner-all" cols="10" rows="4" ><?php echo $obj->referencias; ?></textarea>
    <br />
    
    <label for="ref" class="labeless">Palabras Claves:</label><br />
    <textarea name="palabrasclaves" id="palabrasclaves" style="width: 70%; margin-left:16%;" class="text ui-widget-content ui-corner-all" cols="10" rows="4" ><?php echo $obj->palabrasclaves; ?></textarea>
    <br />
    
    <label for="anex" class="labeless">Anexo:</label>
    <input id="anexo" name="anexo" onkeypress="return permite(event,'num_car');" class="text ui-widget-content ui-corner-all" style=" width: 190px; text-align: left;" value="<?php echo $obj->anexo; ?>" />    
    <br />
    
    <label for="estado" class="labeless">Expositor:</label>
    <input id="expositor" name="expositor" onkeypress="return permite(event,'num_car');" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->expositor; ?>" />    
    <input type="hidden" id="idpersonal" name="idpersonal" value="<?php echo $obj->idpersonal; ?>" />
    
    <label for="estado" class="labeless">Email Exposit.:</label>
    <input id="emailexp" name="emailexp" onkeypress="return permite(event,'num_car');" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->emailexp; ?>" />  

</form>
