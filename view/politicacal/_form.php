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
    <input type="hidden" name="controller" value="politicacal" />
    <input type="hidden" name="action" value="save" />
    <input type="hidden" id="idpolitica_calidad" name="idpolitica_calidad" value="<?php echo $obj->idpolitica_calidad; ?>" />
       
        
        <label for="descripcion" class="labels">Descripcion:</label>
        <textarea name="descripcion" id="descripcion" style="width: 80%; margin-left:16%;" class="text ui-widget-content ui-corner-all" cols="80" rows="6"><?php echo $obj->descripcion ?></textarea><br />
        
        <label for="descripcion" class="labels">Subir Imagen:</label>
        <div class="subir_file">
            <input type="hidden" name="archivo" id="archivo" value="<?php echo $obj->img; ?>" />
                <?php
                    if($obj->img!="")
                        $d = "inline";
                    else
                        $d = "none";
                ?>
            <div id="queue"></div>
            <input id="file_upload" name="file_upload" type="file" multiple="true" />    
            <a target="_blank" href="images/index/<?php echo $obj->file ?>" style="display:<?php echo $d; ?>;cursor:pointer; font-size: 11px;" id="VerImagennn"><img src="images/pdf.png" />Abrir Archivo</a>
            
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
