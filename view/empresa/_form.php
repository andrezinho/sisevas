<?php  include("../lib/helpers.php"); 
       include("../view/header_form.php");
?>
<style type="text/css">
.subir_logo{
    margin-left: 40%;
    margin-top: 2%;
}

</style>

<form id="frm" >
    <input type="hidden" name="controller" value="empresa" />
    <input type="hidden" name="action" value="save" />
    <input type="hidden" id="idempresa" name="idempresa" value="<?php echo $obj->idempresa; ?>" />
       
        
        <label for="razonsocial" class="labels">Razon Social:</label>
        <input id="razonsocial" name="razonsocial" class="text ui-widget-content ui-corner-all" style=" width: 320px; text-align: left;" value="<?php echo $obj->razonsocial; ?>" />
        <br/>
        
        <label for="descripcion" class="labels">Ruc:</label>
        <input id="ruc" name="ruc" onkeypress="return permite(event,'num');" class="text ui-widget-content ui-corner-all" style=" width: 100px; text-align: left;" value="<?php echo $obj->ruc; ?>" />
        
        <label for="descripcion" class="labels">Telefono:</label>
        <input id="telefono" name="telefono" onkeypress="return permite(event,'num_car');" class="text ui-widget-content ui-corner-all" style=" width: 100px; text-align: left;" value="<?php echo $obj->telefono; ?>" />
        <br/>
        
        <label for="razonsocial" class="labels">Direccion:</label>
        <input id="direccion" name="direccion" class="text ui-widget-content ui-corner-all" style=" width: 320px; text-align: left;" value="<?php echo $obj->direccion; ?>" />
        <br/>
        
        <label for="razonsocial" class="labels">Web:</label>
        <input id="web" name="web" class="text ui-widget-content ui-corner-all" style=" width: 320px; text-align: left;" value="<?php echo $obj->web; ?>" />
        <br/>
        
        <label for="razonsocial" class="labels">Email:</label>
        <input id="email" name="email" class="text ui-widget-content ui-corner-all" style=" width: 320px; text-align: left;" value="<?php echo $obj->email; ?>" />
        <br/>
        
        <label for="razonsocial" class="labels">Subir Logo:</label>
        <div class="subir_logo">
            <input type="hidden" name="archivo" id="archivo" value="<?php echo $obj->logo; ?>" />
                <?php
                    if($obj->logo!="")
                        $d = "inline";
                    else
                        $d = "none";
                ?>
            <div id="queue"></div>
            <input id="logo_upload" name="logo_upload" type="logo" multiple="true" />    
            <a target="_blank" href="images/index/<?php echo $obj->logo ?>" style="display:<?php echo $d; ?>;cursor:pointer; font-size: 11px;" id="VerImagennn"><img src="images/pdf.png" />Abrir Archivo</a>
            
        </div>
       
</form>
