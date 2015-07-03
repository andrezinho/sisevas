<?php  
    include("../lib/helpers.php"); 
    include("../view/header_form.php");       
    $Hora_server = date('H:i:s');
    $IdUser= $_SESSION['idusuario'];
?>
   
<form id="frm_inf" >
    <input type="hidden" name="controller" value="informeme" />
    <input type="hidden" name="action" value="save" />    
    
    <div id="tabs">
        <ul style="background:#DADADA !important; border:0 !important">
            <li><a href="#tabs-1">Informaci&oacute;n B&aacute;sica</a></li>
            <li><a href="#tabs-2">Asignaci&oacute;n de tareas</a></li>            
        </ul>
        <div id="tabs-1">
            <div id="table-per">
            
                <fieldset class="fieldset"> 
                    <legend class="legend">Semana de Presentacion:</legend>
                    <label for="fecha" class="labeless">Fecha Incio :</label>
                    <input type="text" name="fechaini" id="fechaini" class="ui-widget-content ui-corner-all text" value="<?php if($obj->fechaini!=""){echo fdate($obj->fechaini,'ES');} else {echo date('d/m/Y');} ?>" style="width:70px; text-align:center" />

                    <label for="fecha" class="labeless">Fecha Fin :</label>
                    <input type="text" name="fechafin" id="fechafin" class="ui-widget-content ui-corner-all text" value="<?php if($obj->fechafin!=""){echo fdate($obj->fechafin,'ES');} else {echo date('d/m/Y');} ?>" style="width:70px; text-align:center" />
                    
                    <label for="fecha" class="labeless">Codigo :</label>
                    <input type="text" name="codigo" id="codigo" class="ui-widget-content ui-corner-all text" value="<?php echo $obj->codigo; ?>" style="width:100px; text-align:center" readonly />
                    <input type="hidden" name="correlativo" id="correlativo" value="<?php echo $obj->correlativo; ?>" />
                </fieldset>
                
                <input type="hidden" id="idinforme" name="idinforme" value="<?php echo $obj->idinforme; ?>" />
                <input type="hidden" name="horareg" value="<?php echo $Hora_server; ?>" />
                <input type="hidden" id="consultorio" name="consultorio"  value="<?php if($obj->idconsultorio!=""){echo $obj->idconsultorio;} else {echo $_SESSION['idconsultorio'];} ?>" />
                <input type="hidden" id="idusuario" name="idusuario"  value="<?php if($obj->idpersonal!=""){echo $obj->idpersonal;} else {echo $_SESSION['idusuario'];} ?>" />
                
                <br />
                <label for="fuente" class="labeless">Unidad Operativa :</label> 
                <?php echo $idconsultorio; ?>
                
                <label for="eje" class="labeless">Personal :</label> 
                <select name="idpersonal" id="idpersonal" class="text ui-widget-content ui-corner-all">
                    <option value="0">.:: Seleccione ::.</option>
                </select>
                <br />
                <!--
                <label for="objemp" class="labeless">Objetivo de emp.:</label> 
                <?php echo $objemp; ?>
                       
                <br />
                
                <label for="objcap" class="labeless">Eje de capac.:</label> 
                <?php echo $eje; ?>
                
                <label for="objcap" class="labeless">Documento Adjunto:</label>
                <input id="codigodoc" name="codigodoc" class="text ui-widget-content ui-corner-all" style=" width: 120px; text-align: center;" value="<?php echo $obj->codigodoc; ?>" />
                <input id="asunto" name="asunto" class="text ui-widget-content ui-corner-all" style=" width: 520px; text-align: left;" value="<?php echo $obj->asunto; ?>" />
                &nbsp;&nbsp;<a class="printer box-boton boton-print" href="#" title="Ver Documento"></a>
                <input type="hidden" id="idtramite" name="idtramite" value="<?php echo $obj->idtramite; ?>" />
                <input type="hidden" id="idtpdoc" name="idtpdoc" value="<?php echo $obj->idtipo_documento; ?>" />
                <br />
                
                
                <label for="eje" class="labeless">Funciones de la Un. Ope.:</label>
                <br />
                <select name="idfuncionesuop" id="idfuncionesuop" class="text ui-widget-content ui-corner-all">
                    <option value="0">.:: Seleccione Funciones ::.</option>
                </select>
                <br />
                                
                <label for="eje" class="labeless">Tiempo de Dedicacion:</label> 
                <input type="hidden" id="idejecapacitacion" name="idejecapacitacion"  value="<?php echo $obj->idejecapacitacion; ?>" />
                <input id="ejecap" name="ejecap" value="<?php echo $obj->ejecap; ?>"  class="text ui-widget-content ui-corner-all" style=" width: 150px; text-align: center;" readonly />
                <br />
                
                
                <label for="objcap" class="labeless">Medio de Verificacion:</label> 
                <?php echo $mediosverif; ?>
                <br />
                
                <label for="objcap" class="labeless">Indicador:</label> 
                <input id="indicador" name="indicador" onkeypress="return permite(event,'num');" value="<?php echo $obj->indicador; ?>"  class="text ui-widget-content ui-corner-all" style=" width: 50px; text-align: center;" />
                
                <label for="objcap" class="labeless">Grado de Avance:</label> 
                <input id="gradoavance" name="gradoavance" onkeypress="return permite(event,'num');" value="<?php echo $obj->gradoavance; ?>"  class="text ui-widget-content ui-corner-all" style=" width: 50px; text-align: center;" />(20,40,50,70,90,100)%
                <br />
                -->
                <label for="ref" class="labeless">Observaciones :</label><br />
                <textarea name="observaciones" id="observaciones" style="width: 70%; margin-left:16%;" class="text ui-widget-content ui-corner-all" cols="15" rows="3" ><?php echo $obj->observaciones; ?></textarea>
                <br />
                <?php
                    if($IdUser==14 || $IdUser==1)
                    {
                    ?>
                    <label for="ref" class="labeless">Notas :</label><br />
                    <textarea name="notas" id="notas" style="width: 70%; margin-left:16%;" class="text ui-widget-content ui-corner-all" cols="15" rows="4" ><?php echo $obj->notas; ?></textarea>
                    <br />
                    <?php
                    }
                ?>
                

            </div>
            
        </div>
                
        <div id="tabs-2">
            <div id="dos">
                <!--
                <label for="tem" class="labeless">Tareas:</label>
                <input id="tareas" name="tareas" class="text ui-widget-content ui-corner-all" style=" width: 600px; text-align: left;" />
                <a href="javascript:" id="addDetail" class="nuevo" title="Nuevo Registro"><span class="box-boton boton-new"></span></a>
                -->
                <br />
                
                <div style="height: 200px; width:810px; overflow: auto; margin: 0 auto;">
                    <table id="table-detalle" class="ui-widget ui-widget-content" style="margin: 0 auto; width:790px" border="0" >
                        <thead class="ui-widget ui-widget-content" >
                            <tr class="ui-widget-header" style="height: 23px">
                                <th align="center" width="30px">N°</th>
                                <th align="center" width="300px">Tareas</th>
                                <th align="center" width="120px">Tiempo</th>
                                <th align="center" width="200px">Objetivo</th>
                                <th align="center" width="75px">Avance</th>
                                <th width="20px">&nbsp;</th>
                            </tr>
                        </thead>  
                        <tbody>
                            <?php 
                                if(count($rowsd)>0)
                                {   $ii=0;
                                    foreach ($rowsd as $i => $r) 
                                    {   
                                        $ii++;
                                        ?>
                                        <tr class="tr-detalle" style="height:23px;">
                                            <td align="center"><?=$ii;?></td>
                                            <td align="left"><?php echo $r['tarea']; ?><input type="hidden" name="idtareasdet[]" value="<?php echo $r['idtareas']; ?>" /></td>
                                            <td align="left"><?php echo $r['eje']; ?></td>
                                            <td align="left"><?php echo $r['obj']; ?></td>
                                            <td align="center">
                                                <input type="text" name="gradodet[]" value="<?=$r['gradoavance']; ?>" class="text ui-widget-content ui-corner-all" style="width:40px; text-align:center" />
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
                                <td colspan="5">&nbsp;</td>
                            </tr>

                        </tfoot>
                    </table>
                </div>
                <br />
                
                
            </div>
        </div>
        
        
    </div>
    
    
</form>
