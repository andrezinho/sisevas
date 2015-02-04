<?php  include("../lib/helpers.php"); 
       include("../view/header_form.php");
?>

   
<form id="frm_obj" >
    <input type="hidden" name="controller" value="objetivosemp" />

    <input type="hidden" name="action" value="save" />
    <input type="hidden" id="idobejtivosemp" name="idobejtivosemp" value="<?php echo $obj->idobejtivosemp; ?>" />
                
        <label for="descripcion" class="labels">Descripcion:</label>
        <input id="descripcion" maxlength="100" name="descripcion" onkeypress="return permite(event,'car');" class="text ui-widget-content ui-corner-all" style=" width: 400px; text-align: left;" value="<?php echo $obj->descripcion; ?>" />
        <br />
            
        <label for="descripcion" class="labels">Subir Imagen:</label>
        <div class="subir_file">
            <input type="hidden" name="archivo" id="archivo" value="<?php echo $obj->img; ?>" />
                <?php
                    if($obj->img!="")
                        $d = "inline";
                    else
                        $d = "none";
                ?>
            <div  style="margin-left:10%; margin-top:2%;" id="queue">
                <input id="file_upload" name="file_upload" type="file" multiple="true" />    
                <a target="_blank" href="images/index/<?php echo $obj->img ?>" style="display:<?php echo $d; ?>;cursor:pointer; font-size: 11px;" id="VerImagennn"><img src="images/pdf.png" />Abrir Archivo</a>
            </div>
        </div>
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
