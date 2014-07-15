<?php  include("../lib/helpers.php"); 
       include("../view/header_form.php");
?>
<style type="text/css">
.subir_file{
    margin-left: 30%;
    margin-top: 2%;
}
.subir_file_v{
    margin-left: 30%;
    margin-top: 2%;
}
</style>

<form id="frm" >
    <input type="hidden" name="controller" value="misionvision" />
    <input type="hidden" name="action" value="save" />
    <input type="hidden" id="idmisionvision" name="idmisionvision" value="<?php echo $obj->idmisionvision; ?>" />
    
    <div id="tabs">
        <ul style="background:#DADADA !important; border:0 !important">
            <li><a href="#tabs-1">Mision</a></li>
            <li><a href="#tabs-2">Vision</a></li>
        </ul>   
        
        <div id="tabs-1">
        
            <label for="descripcion" class="labels">Mision:</label>
            <textarea name="mision" id="mision" style="width: 80%; margin-left:16%;" class="text ui-widget-content ui-corner-all" cols="80" rows="6"><?php echo $obj->mision; ?></textarea>
            <br />
            
            <label for="descripcion" class="labels">Subir Imagen:</label>
            <div class="subir_file">
                <input type="hidden" name="archivo" id="archivo" value="<?php echo $obj->img_m; ?>" />
                    <?php
                        if($obj->img_m!="")
                            $d = "inline";
                        else
                            $d = "none";
                    ?>
                <div id="queue"></div>
                <input id="file_upload" name="file_upload" type="file" multiple="true" />    
                <a target="_blank" href="images/index/<?php echo $obj->img_m ?>" style="display:<?php echo $d; ?>;cursor:pointer; font-size: 11px;" id="VerImagennn"><img src="images/pdf.png" />Abrir Archivo</a>
                
            </div>
            <br />
        </div>
        
        <div id="tabs-2">
            <label for="vision" class="labels">Vision:</label>
            <textarea name="vision" id="vision" style="width: 80%; margin-left:16%;" class="text ui-widget-content ui-corner-all" cols="80" rows="6"><?php echo $obj->vision; ?></textarea>
            <br />
            
            <label for="descripcion" class="labels">Subir Imagen:</label>
            <div class="subir_file_v">
                <input type="hidden" name="archivo_v" id="archivo_v" value="<?php echo $obj->img_v; ?>" />
                    <?php
                        if($obj->img_v!="")
                            $d = "inline";
                        else
                            $d = "none";
                    ?>
                <div id="queue"></div>
                <input id="file_upload_v" name="file_upload_v" type="file" multiple="true" />    
                <a target="_blank" href="images/index/<?php echo $obj->img_v ?>" style="display:<?php echo $d; ?>;cursor:pointer; font-size: 11px;" id="VerImg"><img src="images/pdf.png" />Abrir Archivo</a>
                
            </div>
            <br />
        </div>
           
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
    </div>
</form>
