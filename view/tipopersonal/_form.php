<?php  include("../lib/helpers.php"); 
       include("../view/header_form.php");
?>
<style type="text/css">
.subir_file{
    margin-left: 40%;
    margin-top: 2%;
}

</style>

<form id="frm" >
    <input type="hidden" name="controller" value="TipoPersonal" />
    <input type="hidden" name="action" value="save" />
    <input type="hidden" id="idtipopersonal" name="idtipopersonal" value="<?php echo $obj->idtipopersonal; ?>" />
       
        
        <label for="descripcion" class="labels">Descripcion:</label>
        <input id="descripcion" maxlength="100" name="descripcion" onkeypress="return permite(event,'car');" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->descripcion; ?>" />
        <br />
        
        <label for="descripcion" class="labels">Subir Perfil:</label>
        <div class="subir_file">
            <input type="hidden" name="archivo" id="archivo" value="<?php echo $obj->file; ?>" />
                <?php
                    if($obj->file!="")
                        $d = "inline";
                    else
                        $d = "none";
                ?>
            <div id="queue"></div>
            <input id="file_upload" name="file_upload" type="file" multiple="true">    
            <a target="_blank" href="files/<?php echo $obj->file ?>" style="display:<?php echo $d; ?>;cursor:pointer; font-size: 11px;" id="VerImagennn"><img src="images/pdf.png" />Abrir Archivo</a>
            
        </div>
        <br />
            
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
