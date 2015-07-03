<?php  
    include("../lib/helpers.php"); 
    include("../view/header_form.php");       
    
    $si=1;
?>
   
<form id="frm_cap" >
    <input type="hidden" name="controller" value="desarrollocap" />
    <input type="hidden" name="action" value="save" />
    <input type="hidden" id="idcapacitacion" name="idcapacitacion" value="<?php echo $obj->idcapacitacion; ?>" />
    
    <div id="tabs">
        <ul style="background:#DADADA !important; border:0 !important">
            <li><a href="#tabs-1">Informaci&oacute;n B&aacute;sica</a></li>
            <li><a href="#tabs-2">Asistentes</a></li>
        </ul>
        <div id="tabs-1">
            <div id="table-per">
                
                <label for="tem" class="labeless">Tema:</label>
                <input id="tema" name="tema" onkeypress="return permite(event,'num_car');" class="text ui-widget-content ui-corner-all" style=" width: 500px; text-align: left;" value="<?php echo $obj->tema; ?>" readonly="" />
                <br />
                
                <label for="tem" class="labeless">Acuerdo / Agenda:</label>
                <input id="acuerdo" name="acuerdo" onkeypress="return permite(event,'num_car');" class="text ui-widget-content ui-corner-all" style=" width: 470px; text-align: left;" value="" />
                <br />
                
                <label for="objcap" class="labeless">Asistentes:</label> 
                <input id="personalasist" name="personalasist" onkeypress="return permite(event,'num_car');" class="text ui-widget-content ui-corner-all" style=" width: 380px; text-align: left;" value="" />
                <input type="hidden" name="todosvalor" id="todosvalor" value="0" />
                <?php                     
                    if($filtroest==1 || $filtroest==0)
                        {
                            if($filtroest==1){$act="checked='checked' "; //$inac="";
                            }
                            else {$inac="checked='checked' ";}
                        }
                        else {$act = "checked='checked' ";}
                ?>
                <!--
                <div id="todosp" style="display: inline;">
                Todos
                    <input type="radio" id="todos1" name="todos" value='1' <?php echo $act; ?> onclick="verificar(1);" />
                    <label for="todos1">SI</label>
                    <input type="radio" id="todos0" name="todos" value='0' <?php echo $inac; ?> onclick="verificar(0);" />
                    <label for="todos0">NO</label>
                </div>
                -->
                &nbsp;&nbsp;&nbsp;&nbsp;
                <a href="javascript:" id="addDetail" class="fm-button ui-state-default ui-corner-all fm-button-icon-right ui-reset"><span class="ui-icon ui-icon-plusthick"></span>Agregar</a>
                <br />
                
                <div style="margin: 0 auto; height: 180px !important; overflow: scroll;">
                    <table id="table-detalle" class="ui-widget ui-widget-content" style="margin: 0 auto; width:640px" border="0" >
                        <thead class="ui-widget ui-widget-content" >
                            <tr class="ui-widget-header" style="height: 23px; font-size: 13px;">
                                <th colspan="3" align="center">
                                    ACTA N&ordm: <input type="text" size="16" id="nroacta" name="nroacta"  value="<?php echo $obj->nroacta; ?>" readonly="" />
                                </th>
                            </tr>
                            <tr class="ui-widget-header" style="height: 23px">          
                                <th align="center" width="400px">Acuerdo / Agenda</th>
                                <th align="center" width="220px">Asignado</th>
                                <th width="20px">&nbsp;</th>
                            </tr>
                        </thead>  
                        <tbody>
                            <?php 
                                if(count($rowsac)>0)
                                {    
                                    foreach ($rowsac as $i => $r) 
                                    {   
                                        
                                        ?>
                                        <tr class="tr-detalle" style="height: 23px">
                                            <td align="left"><?php echo $r['acuerdo']; ?><input type="hidden" name="acuerdocap[]" value="<?php echo $r['acuerdo']; ?>" /></td>
                                            <td align="left"><?php echo $r['asistente']; ?>
                                                <input type="hidden" name="idasistente[]" value="<?php echo $r['idasistente']; ?>" />
                                                <input type="hidden" name="asistentedet[]" value="<?php echo $r['asistente']; ?>" />
                                            </td>
                                            <td align="center"><a class="box-boton boton-delete" href="#" title="Quitar" ></a></td>
                                        </tr>
                                        <?php    
                                        }  
                                }
                             ?>                      
                        </tbody>
                         <tfoot>
                            <tr>               
                                <td colspan="3">&nbsp;</td>
                            </tr>
                           
                        </tfoot>
                    </table>
                </div>
                <br />
                
                <label for="lug" class="labeless">Lugar de Reu.:</label>
                <input id="lugarreunion" name="lugarreunion" onkeypress="return permite(event,'num_car');" class="text ui-widget-content ui-corner-all" style=" width: 470px; text-align: left;" value="<?php echo $obj->lugarreunion; ?>" />
                <br />
                
                <label for="hora" class="labeless">Hora Inicio:</label>
                <input type="text" name="horacap" id="horacap" value="<?php if($obj->hora!=""){echo $obj->hora; } else {echo date('H:i');} ?>" class="ui-widget-content ui-corner-all text" style="width:60px; text-align:center" />
                               
                <label for="objcap" class="labels">Hora Fin:</label> 
                <input type="text" name="horacapfin" id="horacapfin" value="<?php if($obj->horafin!=""){echo $obj->horafin; } else {echo date('H:i');} ?>" class="ui-widget-content ui-corner-all text" style="width:60px; text-align:center" />               
                                
                <label for="estado" class="labeless">Fin de la capacitacion?:</label>
                <div id="estados" style="display:inline">                
                <?php                   
                    if($si==1 || $si==0)
                    {
                        if($si==1){$rep=1;}
                        else {$rep=1;}
                    }
                    else {$rep = 1;}                    
                        activo('activo',$rep);
                ?>
                </div>
                
            </div>
            
        </div>     
        
        <div id="tabs-2">
            <table id="detalles" class="ui-widget ui-widget-content" style="margin: 0 auto; width:600px" border="0" >
                <thead class="ui-widget ui-widget-content" >
                    <tr class="ui-widget-header" style="height: 23px">
                        <th align="center" width="300px">Destinatarios</th>
                        <th align="center" width="180px">Tipo Alcance</th>
                        <th width="20px">&nbsp;</th>
                    </tr>
                </thead>  
                <tbody>
                    <?php 
                        if(count($rowasis)>0)
                        {    
                            foreach ($rowasis as $id => $rs) 
                            {                                          
                                ?>
                                <tr class="tr-detalle" style="height: 21px">
                                    <td align="left">
                                        <?php echo $rs['asistentes']; ?>                                       
                                        <input type="hidden" name="idpersonalasignado[]" value="<?php echo $rs['idpersonalasig']; ?>" />

                                    </td>                                        
                                    <td>
                                        <?php echo $rs['descripcion']; ?>
                                        <input type="hidden" name="idtipoalcance[]" value="<?php echo $rs['idtipoalcance']; ?>" />
                                    </td>
                                    <td align="center"><a class="box-boton boton-deletes" href="#" title="Quitar" ></a></td>
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
        </div>
        
    </div>
    
    
</form>
