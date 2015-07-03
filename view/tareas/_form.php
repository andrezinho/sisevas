<?php
    include("../lib/helpers.php");
    include("../view/header_form.php");
    
    $nrominutos=isset($obj->nrominutos) ? $obj->nrominutos  : 0; //$obj->nrominutos;
?>
<div style="padding :10px 20px">
    <form id="frm_temas" >
        <input type="hidden" name="controller" value="tareas" />
        <input type="hidden" name="action" value="save" />   
        <input type="hidden" id="idtareas" name="idtareas" value="<?php echo $obj->idtareas; ?>" />
        <input type="hidden" id="idcargo" name="idcargo" value="<?php echo $_SESSION['idcargoper']; ?>" />
        <input type="hidden" id="idfuncion" name="idfuncion" value="<?php echo $obj->idfuncionesuop; ?>" />
        
        <label for="fecha" class="labeless">Fecha Emision :</label>
        <input type="text" name="fechareg" id="fechareg" class="ui-widget-content ui-corner-all text" value="<?php if($obj->fechareg!=""){echo fdate($obj->fechareg,'ES');} else {echo date('d/m/Y');} ?>" style="width :70px; text-align :center" />

        <label for="descripcion" class="labeless">Tarea :</label>
        <input type="text" id="descripcion" maxlength="500" name="descripcion" class="text ui-widget-content ui-corner-all" style=" width : 470px; text-align : left;" value="<?php echo $obj->tarea; ?>" />
        <br/>        
             
        <label for="tiempo" class="labeless">Tiempo Dedicacion :</label>
        <?php echo $ejes; ?>
        <br/>
        
        <label for="obj" class="labeless">Objetivo Empresa :</label>
        <?php echo $objemp; ?>
        <br/>
        
        <label for="eje" class="labeless">Funciones MOF :</label>
        <br />
        <select name="idfuncionesuop" id="idfuncionesuop" class="text ui-widget-content ui-corner-all">
            <option value="0">.:: Seleccione Funciones ::.</option>
        </select>
        <br />
        
        <label for="objcap" class="labeless">Medio de Verificacón :</label> 
        <?php echo $mediosverif; ?>
        <br />
        
        <label for="objcap" class="labeless">Grado Importancia :</label> 
        <?php echo $importancia; ?>
        <br />
        
        <label for="tiemp" class="labeless">Duración de la Actividad :</label> 
        <input id="nrominutos" name="nrominutos" onkeypress="return permite(event,'num');" value="<?php echo $nrominutos; ?>"  class="text ui-widget-content ui-corner-all" style=" width : 50px; text-align : center;" />(min.)
        <br />
        
        <label for="ind" class="labeless">Indicador :</label> 
        <input id="indicador" name="indicador" onkeypress="return permite(event,'num_car');" value="<?php echo $obj->indicador; ?>"  class="text ui-widget-content ui-corner-all" style=" width : 400px;" />
        <br />
        
        <label for="grado" class="labeless">Grado de Avance :</label> 
        <input id="gradoavance" name="gradoavance" onkeypress="return permite(event,'num');" value="<?php echo $obj->gradoavance; ?>"  class="text ui-widget-content ui-corner-all" style=" width : 50px; text-align : center;" />(20,40,50,70,90,100)%
        <br />
                
        <input type="hidden" id="estado" name="estado" value="1" />
        
    </form>
</div>