<?php
    $Hora_server = date('H:i');
    $Horafin = date('H:i');
?>

<script type="text/javascript" src="../web/js/app/evt_form_envio.js"></script>

<div id="table-per"> 
    <label for="fecha" class="labels">Fecha Emision:</label>
    <input type="text" name="fechainicio" id="fechainicio" class="ui-widget-content ui-corner-all text" value="<?php if($obj->fechainicio!=""){echo fdate($obj->fechainicio,'ES');} else {echo date('d/m/Y');} ?>" style="width:70px; text-align:center" readonly />
    <br />
    
    <label for="fecha" class="labels">Hora Ini.:</label>
    <input type="text" name="horainicio" class="ui-widget-content ui-corner-all text" value="<?php echo $Hora_server; ?>" style=" width: 50px; text-align: center;" />
    
    <label for="fecha" class="labeless">Hora Fin.:</label>
    <input type="text" name="horafin" class="ui-widget-content ui-corner-all text" value="<?php echo $Horafin; ?>" style=" width: 50px; text-align: center;" />
    <br />
        
        <!--
        <label for="destinatario" class="labels">Remitente:</label>
	<?php echo $remitente; ?>
	<br/>-->

	<label for="asunto" class="labels">Tema / Asuntos:</label>
	<input type="text" id="asunto" name="asunto" class="text ui-widget-content ui-corner-all" style=" width: 380px; text-align: left;" value="<?php echo $obj->asunto; ?>" />
	<br />
        
        <label for="docref" class="labels">Lugar de Reunion:</label>
	<input type="text" id="lugarreu" name="lugarreu" class="text ui-widget-content ui-corner-all" style=" width: 380px; text-align: left;" value="<?php echo $obj->lugarreu; ?>" />
	<br />
        
	<label for="descripcion" class="labels">Acuerdos:</label><br />
	<textarea name="problema" id="problema" style="width: 80%; margin-left:16%;" class="text ui-widget-content ui-corner-all" cols="20" rows="8" ><?php echo $obj->problema; ?></textarea>
	<br />
        
	<label for="destinatario" class="labels">Asistentes:</label>
	<?php echo $personal; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="javascript:" id="addDetail" class="fm-button ui-state-default ui-corner-all fm-button-icon-right ui-reset"><span class="ui-icon ui-icon-plusthick"></span>Agregar Destiantarios</a>
        

</div>

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