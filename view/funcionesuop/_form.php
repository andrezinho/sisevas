<?php  
    include("../lib/helpers.php"); 
       include("../view/header_form.php");       
?>
<div style="padding:10px 20px">
<form id="frm_consultorio" >
    <input type="hidden" name="controller" value="funcionesuop" />
    <input type="hidden" name="action" value="save" />
   
    <input type="hidden" id="idfuncionesuop" name="idfuncionesuop" value="<?php echo $obj->idfuncionesuop; ?>" />

    <label for="idsede" class="labeless">Unidad Ope.:</label>
    <?php echo $idconsultorio; ?>
    <br/>
    
    <label for="idsede" class="labeless">Perfil Ocupac.:</label>
    <?php echo $idcargo; ?>
    <br/>
    
    <label for="idsede" class="labeless">Tiempo de Dedica.:</label>
    <?php echo $eje; ?>
    <br/>
    
    <label for="descripcion" class="labeless">Descripcion:</label>
    <input type="text" id="descripcion" name="descripcion" value="<?php echo $obj->descripcion; ?>" class="text ui-widget-content ui-corner-all" style=" width: 500px; text-align: left;" />
    <br/>
    
    <label for="estado" class="labeless">Estado:</label>
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
</div>