<?php
$Hora_server = date('H:i');
$Horafin = date('H:i');
?>

<script type="text/javascript" src="../web/js/app/evt_form_envio.js"></script>

<div id="table-per"> 
    <label for="fecha" class="labels">Fecha Emision:</label>
    <input type="text" name="fechainicio" id="fechainicio" class="ui-widget-content ui-corner-all text" value="<?php if ($obj->fechainicio != "") { echo fdate($obj->fechainicio, 'ES');} else {echo date('d/m/Y');} ?>" style="width:70px; text-align:center" readonly />
    
    <label for="fecha" class="labels">Hora Inicio:</label>
    <input type="text" name="horainicio" class="ui-widget-content ui-corner-all text" value="<?php echo $Hora_server; ?>" style=" width: 50px; text-align: center;" />

    <label for="fecha" class="labeles">Hora Fin:</label>
    <input type="text" name="horafin" class="ui-widget-content ui-corner-all text" value="<?php echo $Horafin; ?>" style=" width: 50px; text-align: center;" />
    <br />

    <label for="docref" class="labels">Lugar de Reunion:</label>
    <input type="text" id="lugarreu" name="lugarreu" class="text ui-widget-content ui-corner-all" style=" width: 380px; text-align: left;" value="<?php echo $obj->lugarreu; ?>" />
    <br />

    <label for="asunto" class="labels">Agenda:</label>
    <!--<input type="text" id="asunto" name="asunto" class="text ui-widget-content ui-corner-all" style=" width: 380px; text-align: left;" value="<?php echo $obj->asunto; ?>" />-->
    <textarea name="asunto" id="asunto" style="width: 80%; margin-left:16%;" class="text ui-widget-content ui-corner-all" cols="20" rows="5" ><?php echo $obj->asunto; ?></textarea>
    <br /> 

    <label for="descripcion" class="labels">Acuerdos:</label><br />
    <textarea name="problema" id="problema" style="width: 80%; margin-left:16%;" class="text ui-widget-content ui-corner-all" cols="20" rows="7" ><?php echo $obj->problema; ?></textarea>
    <br />

    <label for="destinatario" class="labels">Asistentes:</label>
    <?php echo $personal; ?>&nbsp;&nbsp;
    <input type="hidden" name="todosvalor" id="todosvalor" value="0" />
    <?php 
       
        if($filtroest==1 || $filtroest==0)
            {
                if($filtroest==1){$act="checked='checked' ";
                }
                else {$inac="checked='checked' ";}
            }
            else {$act = "checked='checked' ";}
    ?>
    
    &nbsp;&nbsp;<b>Nuevo</b>&nbsp;<input name="nuevotem" id="nuevotem" type="checkbox" />&nbsp;&nbsp;||&nbsp;&nbsp;
    
    <div id="todosp" style="display: inline;">
    <b>Todos</b>
        <input type="radio" id="todos1" name="todos" value='1' <?php echo $act; ?> onclick="verificar(1);" />
        <label for="todos1">SI</label>
        <input type="radio" id="todos0" name="todos" value='0' <?php echo $inac; ?> onclick="verificar(0);" />
        <label for="todos0">NO</label>
    </div>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="javascript:" id="addDetail" title="Agregar"><span class="box-boton boton-new"></span></a>
    <br />

    <div id="temanuevo" style="display:none; background: #FFF;">
        <label for="tem" class="labels"><b>Asistente Nuevo:</b></label>
        <input id="dni" name="dni" class="text ui-widget-content ui-corner-all" style=" width: 70px; text-align: left;" maxlength="8" value="" placeholder="DNI"/>
        <input id="nom" name="nom" class="text ui-widget-content ui-corner-all" style=" width: 120px; text-align: left;" value="" placeholder="Nombres"/>
        <input id="app" name="app" class="text ui-widget-content ui-corner-all" style=" width: 220px; text-align: left;" value="" placeholder="Apellidos"/>
        <img src="images/user.png" width="16px" height="16px" title="Crear Nuevo" style="cursor: pointer;" onclick="SaveNexUser();" />
    </div>
</div>
<div style="height: 120px; width:470px; overflow: auto; margin: 0 auto;">
    <table id="table-detalle" class="ui-widget ui-widget-content" style="margin: 0 auto; width:440px" border="0" >
        <thead class="ui-widget ui-widget-content" >
            <tr class="ui-widget-header" style="height: 23px">
                <th align="center" width="200px">Asistentes</th>
                <th width="20px">&nbsp;</th>
            </tr>
        </thead>  
        <tbody>

        </tbody>
        <tfoot>
            <tr>               
                <td colspan="2">&nbsp;</td>
            </tr>

        </tfoot>
    </table>
</div>