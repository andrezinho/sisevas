<?php  
    include("../lib/helpers.php"); 
    include("../view/header_form.php");       
    
?>
   
<form id="frm_cap" >
    <input type="hidden" name="controller" value="desarrollocap" />
    <input type="hidden" name="action" value="save" />
    <input type="hidden" id="idcapacitacion" name="idcapacitacion" value="<?php echo $obj->idcapacitacion; ?>" />
    
    <div id="tabs">
        <ul style="background:#DADADA !important; border:0 !important">
            <li><a href="#tabs-1">Informaci&oacute;n B&aacute;sica</a></li>
        </ul>
        <div id="tabs-1">
            <div id="table-per">
                
                <label for="tem" class="labeless">Tema:</label>
                <input id="tema" name="tema" onkeypress="return permite(event,'num_car');" class="text ui-widget-content ui-corner-all" style=" width: 500px; text-align: left;" value="<?php echo $obj->tema; ?>" readonly="" />
                <br />
                
                <label for="tem" class="labeless">Acuerdo / Agenda:</label>
                <input id="acuerdo" name="acuerdo" onkeypress="return permite(event,'num_car');" class="text ui-widget-content ui-corner-all" style=" width: 470px; text-align: left;" value="<?php echo $obj->acuerdo; ?>" />
                <br />
                
                <label for="objcap" class="labeless">Asistentes:</label> 
                <?php echo $personalasis; ?>                
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
                                if(count($rowsd)>0)
                                {    
                                    foreach ($rowsd as $i => $r) 
                                    {                                          
                                        ?>
                                        <tr class="tr-detalle" style="height: 23px">
                                            <td align="left"><?php echo $r['acuerdo']; ?><input type="hidden" name="idobejtivosempresa[]" value="<?php echo $r['acuerdo']; ?>" /></td>
                                            <td align="left"><?php echo $r['personal']; ?><input type="hidden" name="idobejtivosempresa[]" value="<?php echo $r['personal']; ?>" /></td>
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
                <input type="text" name="horacapfin" id="horacapfin" value="<?php if($obj->horacapfin!=""){echo $obj->horacapfin; } else {echo date('H:i');} ?>" class="ui-widget-content ui-corner-all text" style="width:60px; text-align:center" />               
                                
                <label for="estado" class="labeless">Fin de la capacitacion?:</label>
                <div id="estados" style="display:inline">                
                <?php                   
                    if($obj->externo==1 || $obj->externo==0)
                    {
                        if($obj->externo==1){$rep=1;}
                        else {$rep=0;}
                    }
                    else {$rep = 1;}                    
                        activo('activo',$rep);
                ?>
                </div>
                
            </div>
            
        </div>     
        
        
    </div>
    
    
</form>
