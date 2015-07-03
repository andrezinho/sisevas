<?php  
    include("../lib/helpers.php"); 
    include("../view/header_form.php"); 

    $Hora_server = date('H:i:s');
    $idtpdoc= $obj->idtipo_documento;
      
?>


<div style="padding:10px 20px; min-width:630px; min-height:450px;">
<form id="frm_envio" >

<div id="table-per">

    <input type="hidden" name="controller" value="Envio" />
    <input type="hidden" name="action" value="save" />
    
    <input type="hidden" id="idtramite" name="idtramite" value="<?php echo $obj->idtramite; ?>" />
            
    <label for="tipodoc" class="labels">Tipo documento:</label>
    <?php echo $tipodoc; ?>
    <input type="text" id="correlativo" name="correlativo" class="text ui-widget-content ui-corner-all" style=" width: 100px; text-align: left;" value="<?php echo $obj->codigo; ?>" readonly />
    
    <br/>
    <hr />
    <br/>

    <?php
        if ($idtpdoc== 2 || $idtpdoc== 3) {
        ?>
            <div id="tabs">
                <ul style="background:#DADADA !important; border:0 !important">
                    <li><a href="#tabs-1">Información Del CLiente</a></li>
                    <li><a href="#tabs-2">Información Del Problema</a></li>

                </ul>
                <div id="tabs-1">

                    <fieldset>
                        <label for="nombres" class="labels">Cliente:</label>
                        <input type="text" id="nombres" maxlength="150" name="nombres" value="<?php echo $obj->nombres; ?>" onkeypress="return permite(event,'car');" class="text ui-widget-content ui-corner-all" style=" width: 150px; text-align: left;" placeholder="Nombres" />
                        <input type="hidden" id="idpaciente" name="idpaciente" value="<?php echo $obj->idpaciente; ?>" />
                        <input type="hidden" name="horainicio" value="<?php echo $Hora_server; ?>" />
                        <input type="hidden" name="fechainicio" id="fechainicio" value="<?php if($obj->fechainicio!=""){echo fdate($obj->fechainicio,'ES');} else {echo date('d/m/Y');} ?>" />

                        <input type="text" id="apellidopat" maxlength="150" name="apellidopat" value="<?php echo $obj->appat; ?>" onkeypress="return permite(event,'car');" class="text ui-widget-content ui-corner-all" style=" width: 150px; text-align: left;" placeholder="Ap. Paterno" />
                        <input type="text" id="apellidomat" maxlength="150" name="apellidomat" value="<?php echo $obj->appat; ?>" onkeypress="return permite(event,'car');" class="text ui-widget-content ui-corner-all" style=" width: 150px; text-align: left;" placeholder="Ap. Materno" />
                        <br />

                        <label for="direccion" class="labels">DNI:</label>
                        <input type="text" id="dni" maxlength="150" name="dni" placeholder="DNI" value="<?php echo $obj->nrodocumento; ?>" onkeypress="return permite(event,'num_car');" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" />

                        <label for="direccion" class="labels">Domicilio:</label>
                        <input type="text" id="direccion" maxlength="150" name="direccion" placeholder="Direccion" value="<?php echo $obj->direccion; ?>" onkeypress="return permite(event,'num_car');" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" />
                        <br />

                        <label for="telefonos" class="labels">Telefonos:</label>
                        <input type="text" id="telefonos" maxlength="150" name="telefonos" value="<?php echo $obj->telefono; ?>" placeholder="Telefono" onkeypress="return permite(event,'num_car');" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;"  />

                        <label for="asunto" class="labels">Celular:</label>
                        <input type="text" id="celular" maxlength="150" name="celular" value="<?php echo $obj->celular; ?>" placeholder="Celular" onkeypress="return permite(event,'num_car');" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" />

                    </fieldset>

                </div>
                <div id="tabs-2">

                    <fieldset class="fieldset">
                        <legend>Descripción del problema</legend>
                        <textarea name="problema" id="problema" style="width: 95%; margin-left: 20px;" class="text ui-widget-content ui-corner-all" cols="30" rows="10" ><?php echo $obj->problema; ?></textarea>
                        <br />

                        <label for="destinatario" class="labels">Tipo :</label>
                        <?php echo $tipoproblema; ?>
                        <br />

                        <label for="destinatario" class="labels">Area o Servicio:</label>
                        <!-- <select name="idareai" id="idareai" class="ui-widget-content ui-corner-all text" style="width:150px">
                            <option value="">Seleccione....</option>
                        </select> -->
                        <?php echo $idareai; ?>
                    </fieldset>

                </div>

            </div>
        
        <?php
        }
        
        if ($idtpdoc== 1 || $idtpdoc== 4 || $idtpdoc== 5) {
        
    ?>
            <label for="fecha" class="labels">Fecha Emision:</label>
            <input type="text" name="fechainicio" id="fechainicio" class="ui-widget-content ui-corner-all text" value="<?php if($obj->fechainicio!=""){echo fdate($obj->fechainicio,'ES');} else {echo date('d/m/Y');} ?>" style="width:70px; text-align:center" readonly />
            <input type="hidden" name="horainicio" value="<?php echo $Hora_server; ?>" />
            <br />
            
            <label for="destinatario" class="labels">Remitente:</label>
            <?php echo $remitente; ?>
            <br/>

            <label for="asunto" class="labels">Asunto:</label>
            <input type="text" id="asunto" maxlength="150" name="asunto" onkeypress="return permite(event,'car');" class="text ui-widget-content ui-corner-all" style=" width: 230px; text-align: left;" value="<?php echo $obj->asunto; ?>" />
            <br />

            <label for="descripcion" class="labels">Descripcion:</label><br />
            <textarea name="problema" id="problema" style="width: 80%; margin-left:16%;" class="text ui-widget-content ui-corner-all" cols="20" rows="4" ><?php echo $obj->problema; ?></textarea>
            <br />

            <label for="docref" class="labels">Doc. Referenc.:</label>
            <input type="text" id="docref" maxlength="100" name="docref" onkeypress="return permite(event,'num_car');" class="text ui-widget-content ui-corner-all" style=" width: 230px; text-align: left;" value="<?php echo $obj->docref; ?>" />
            <br />

            <label for="destinatario" class="labels">Destinatario:</label>
            <?php echo $personal; ?>&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="javascript:" id="addDetail" class="fm-button ui-state-default ui-corner-all fm-button-icon-right ui-reset"><span class="ui-icon ui-icon-plusthick"></span>Agregar Destiantarios</a>
            <br />
            <br />

            <table id="table-detalle" class="ui-widget ui-widget-content" style="margin: 0 auto; width:440px" border="0" >
                <thead class="ui-widget ui-widget-content" >
                    <tr class="ui-widget-header" style="height: 23px">
                        <th align="center" width="200px">Destinatarios</th>
                        <th width="20px">&nbsp;</th>
                    </tr>
                </thead>  
                <tbody>
                <?php
                    if(count($rowsd)>0)
                        {    
                            foreach ($rowsd as $i => $r) 
                            {
                        ?>

                        <tr class="tr-detalle" style="height: 20px">
                            <td width="200px">
                                <?php echo $r['destinatario']; ?>                                
                                <input type="hidden" name="idpersonaldet[]" value="<?php echo $r['idpersonal']; ?>" />
                            </td>
                            <td align="center" width="20px"><a class="box-boton boton-delete" href="#" title="Quitar" ></a></td>
                        </tr>

                        <?php
                            } 
                        }
                ?>                  
                </tbody>
                 <tfoot>
                    <tr>               
                        <td colspan="2">&nbsp;</td>
                    </tr>
                   
                </tfoot>
            </table>
        <?php
        }
        
        if ($idtpdoc== 10 || $idtpdoc== 11 || $idtpdoc== 12) {
        
    ?>
            <label for="fecha" class="labels">Fecha Emision:</label>
            <input type="text" name="fechainicio" id="fechainicio" class="ui-widget-content ui-corner-all text" value="<?php if($obj->fechainicio!=""){echo fdate($obj->fechainicio,'ES');} else {echo date('d/m/Y');} ?>" style="width:70px; text-align:center" readonly />
            <br />
            
            <label for="fecha" class="labels">Hora Ini.:</label>
            <input type="text" name="horainicio" class="ui-widget-content ui-corner-all text" value="<?php echo $obj->horainicio; ?>" style=" width: 50px; text-align: center;" />
            
        <?php 
            if($idtpdoc== 10 || $idtpdoc== 12)
            {
            ?>
                
            <label for="fecha" class="labeless">Hora Fin.:</label>
            <input type="text" name="horafin" class="ui-widget-content ui-corner-all text" value="<?php echo $obj->horafin; ?>" style=" width: 50px; text-align: center;" />
            
            <?php
            }
            else {
            ?>
            
            <input type="hidden" name="horafin" value="<?php echo $obj->horafin; ?>" />
            <?php
            }
        ?>
            <br />
        <?php 
            if($idtpdoc== 10 || $idtpdoc== 12)
            {
            ?>
                
            <label for="asunto" class="labels">Tema / Asuntos:</label>
            <!--<input type="text" id="asunto" name="asunto" class="text ui-widget-content ui-corner-all" style=" width: 380px; text-align: left;" value="<?php echo $obj->asunto; ?>" />-->
            <textarea name="asunto" id="asunto" style="width: 80%; margin-left:16%;" class="text ui-widget-content ui-corner-all" cols="20" rows="5" ><?php echo $obj->asunto; ?></textarea>
            
            <?php
            }
            else {
            ?>
            
            <input type="hidden" id="asunto" name="asunto" value="<?php echo $obj->asunto; ?>" />
            <?php
            }
        ?>               
            <br />

            <label for="docref" class="labels">Lugar de Reunion:</label>
            <input type="text" id="lugarreu" name="lugarreu" class="text ui-widget-content ui-corner-all" style=" width: 380px; text-align: left;" value="<?php echo $obj->lugarreu; ?>" />
            <br />

            <label for="descripcion" class="labels">Acuerdos:</label><br />
            <textarea name="problema" id="problema" style="width: 80%; margin-left:16%;" class="text ui-widget-content ui-corner-all" cols="20" rows="8" ><?php echo $obj->problema; ?></textarea>
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

            <div id="todosp" style="display: inline; margin-right: 10px;">
            <b>Todos</b>
                <input type="radio" id="todos1" name="todos" value='1' <?php echo $act; ?> onclick="verificar(1);" />
                <label for="todos1">SI</label>
                <input type="radio" id="todos0" name="todos" value='0' <?php echo $inac; ?> onclick="verificar(0);" />
                <label for="todos0">NO</label>
            </div>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="#" id="addDetail" title="Agregar" class="box-boton boton-new"></a>
            <br />

            <div id="temanuevo" style="display:none; background: #FFF;">
                <label for="tem" class="labels"><b>Asistente Nuevo:</b></label>
                <input id="dni" name="dni" class="text ui-widget-content ui-corner-all" style=" width: 70px; text-align: left;" maxlength="8" value="" placeholder="DNI"/>
                <input id="nom" name="nom" class="text ui-widget-content ui-corner-all" style=" width: 120px; text-align: left;" value="" placeholder="Nombres"/>
                <input id="app" name="app" class="text ui-widget-content ui-corner-all" style=" width: 220px; text-align: left;" value="" placeholder="Apellidos"/>
                <img src="images/user.png" width="16px" height="16px" title="Crear Nuevo" style="cursor: pointer;" onclick="SaveNexUser();" />
            </div>
            <br />

            <table id="table-detalle" class="ui-widget ui-widget-content" style="margin: 0 auto; width:440px" border="0" >
                <thead class="ui-widget ui-widget-content" >
                    <tr class="ui-widget-header" style="height: 23px">
                        <th align="center" width="200px">Destinatarios</th>
                        <th width="20px">&nbsp;</th>
                    </tr>
                </thead>  
                <tbody>
                <?php
                    if(count($rowsd)>0)
                        {    
                            foreach ($rowsd as $i => $r) 
                            {
                        ?>

                        <tr class="tr-detalle" style="height: 20px">
                            <td width="200px">
                                <?php echo $r['destinatario']; ?>                                
                                <input type="hidden" name="idpersonaldet[]" value="<?php echo $r['idpersonal']; ?>" />
                            </td>
                            <td align="center" width="20px"><a class="box-boton boton-delete" href="#" title="Quitar" ></a></td>
                        </tr>

                        <?php
                            } 
                        }
                ?>                  
                </tbody>
                 <tfoot>
                    <tr>               
                        <td colspan="2">&nbsp;</td>
                    </tr>
                   
                </tfoot>
            </table>
        <?php
        }
    ?>
    
</div>
    
</form>
</div>
