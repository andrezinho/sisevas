<?php  
    include("../lib/helpers.php"); 
    include("../view/header_form.php");   
?>
<?php $timestamp = time();?>
<script src="js/jquery.uploadify.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="css/uploadify.css" />
<script type="text/javascript">
$(function() {
        
    getAnexos();
    $('#file_upload').uploadify({
            'formData' : {
                'timestamp' : '<?php echo $timestamp;?>',
                'token'     : '<?php echo md5('unique_salt' . $timestamp);?>',
                'idcapacitacion': '<?php echo $obj->idcapacitacion; ?>',
                'controller':'capacitacionasig',
                'action':'upload_file'
            },
            'swf'      : 'uploadify.swf',
            'uploader' : 'index.php',
            'buttonText': 'Archivo',
            'height'   : 21,
            onUploadSuccess : function(file, data, response) {
                    if(response)
                    {                            
                        r = data.split("###");
                        if(r[0]==1)
                        {                                
                            getAnexos();
                        }
                        else 
                        {
                            alert(r[1]);
                        }                            
                    }
                    else 
                    {
                        alert("Ha ocurrido un error al intentar subir el archivo "+file.name);
                    }

                },
            onUploadError : function(file, errorCode, errorMsg, errorString) 
                {
                    alert('El archivo ' + file.name + ' no pudo ser subido: ' + errorString);
                }
    });

    $("#tabla-anexos tbody").on('click','.delete-anexo',function(){
        var i = $(this).attr("id");
        i = i.split("-");
        deleting(i[1]);
    });
    
});

function getAnexos()
{
    var idc = $("#idcapacitacion").val();
    html = '';
    $.get('index.php','controller=capacitacionasig&action=getAnexos&idc='+idc,function(data){
        $.each(data,function(i,j){
            html += '<tr>';
            html += '<td align="center">'+(i+1)+').</td>'
            html += '<td><a target="_blank" href="files_uploads/'+j.nombre+'.'+j.ext+'"><img src="images/'+j.icono+'" /></a></td>';
            html += '<td><a target="_blank" href="files_uploads/'+j.nombre+'.'+j.ext+'">'+j.nombre+'</a></td>';
            html += '<td><a href="javascript:" class="delete-anexo" id="anexo-'+j.idanexo+'" style="color:red">Eliminar</a></td>';
            html += '</tr>';
        })
        $("#tabla-anexos tbody").empty().append(html);
    },'json');

}
function deleting(i)
{
    $.post('index.php','controller=capacitacionasig&action=delete_anexo&ida='+i,function(data){
        getAnexos();
    });
}
</script>

<form id="frm_cap" >
    <input type="hidden" name="controller" value="capacitacionasig" />
    <input type="hidden" name="action" value="save" />
    <input type="hidden" id="idcapacitacion" name="idcapacitacion" value="<?php echo $obj->idcapacitacion; ?>" />
    
    <div id="tabs">
        <ul style="background:#DADADA !important; border:0 !important">
            <li><a href="#tabs-1">Informaci&oacute;n B&aacute;sica</a></li>
            <li><a href="#tabs-2">Propuesta</a></li>
            <li><a href="#tabs-3">Asignacion</a></li>
            <li><a href="#tabs-4">Anexos</a></li>
            <li><a href="#tabs-5">Presupuesto</a></li>
        </ul>
        <div id="tabs-1">
            <div id="table-per">
                
                <label for="fuente" class="labeless">Fuente de cap.:</label> 
                <?php echo $fuente; ?>
                
                <label for="eje" class="labeless">Eje de capac.:</label> 
                <?php echo $eje; ?>
                <br />
                
                <label for="linea" class="labeless">Linea Accion:</label>
                <input id="lineaaccion" name="lineaaccion" onkeypress="return permite(event,'num_car');" class="text ui-widget-content ui-corner-all" style=" width: 520px; text-align: left;" value="<?php echo $obj->descripcion; ?>" />
                <input type="hidden" name="idlineaaccion" id="idlineaaccion" value="<?php echo $obj->idlineaaccion; ?>" />
                <br />
                  
                <label for="tem" class="labeless">Tema:</label>
                <input id="tema" name="tema" onkeypress="return permite(event,'num_car');" class="text ui-widget-content ui-corner-all" style=" width: 520px; text-align: left;" value="<?php echo $obj->tema; ?>" />
                <br />
                
                <label for="objcap" class="labeless">Objetivo de capac.:</label> 
                <?php echo $objcap; ?>
                <br />
                
                <label for="objemp" class="labeless">Objetivo de emp.:</label> 
                <?php echo $objemp; ?>
                <a href="javascript:" id="addDetail" class="nuevo" title="Nuevo Registro"><span class="box-boton boton-new"></span></a>       
                
                <table id="table-detalle" class="ui-widget ui-widget-content" style="margin: 0 auto; width:640px" border="0" >
                    <thead class="ui-widget ui-widget-content" >
                        <tr class="ui-widget-header" style="height: 23px">          
                            <th align="center" width="620px">Objetivo de la empresa</th>
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
                                        <td align="left"><?php echo $r['descripcion']; ?><input type="hidden" name="idobejtivosemp[]" value="<?php echo $r['idobejtivosemp']; ?>" /></td>
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
                <br />
                
                <label for="objcap" class="labeless">Metodo:</label> 
                <?php echo $metodo; ?>
                
                <label for="objcap" class="labels">Tipo Evaluacion:</label> 
                <?php echo $tipoeva; ?>
                <br />                
                
                <label for="estado" class="labeless">Expositor:</label>
                <input id="expositordni" name="expositordni" onkeypress="return permite(event,'num');" class="text ui-widget-content ui-corner-all" style=" width: 60px; text-align: left;" value="<?php echo $obj->dni; ?>" placeholder="DNI" />
                <input id="nombresexpositor" name="nombresexpositor" onkeypress="return permite(event,'num_car');" class="text ui-widget-content ui-corner-all" style=" width: 150px; text-align: left;" value="<?php echo $obj->nombres; ?>" placeholder="NOMBRES" /> 
                <input id="apellidosexpositor" name="apellidosexpositor" onkeypress="return permite(event,'num_car');" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->apellidos; ?>" placeholder="APELLIDOS" /> 
                <input type="hidden" id="idpersonal" name="idpersonal" value="<?php echo $obj->idpersonal; ?>" />
                <div id="estados" style="display:inline">
                Externo
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
                
                
                <br />
                
                <label for="estado" class="labeless">Email Expositor:</label>
                <input id="emailexp" name="emailexp" value="<?php echo $obj->mail; ?>" onkeypress="return permite(event,'num_car');" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" />  
                
                <label for="fechanaci" class="labels">Fecha Cap:</label>
                <input type="text" id="fechacap" name="fechacap" value="<?php if($obj->fecha=='') echo date('d/m/Y'); else echo fdate($obj->fecha,'ES'); ?>" class="text ui-widget-content ui-corner-all" style=" width: 70px; text-align: center;" />
                
                <label for="hora" class="labels">Hora cap. :</label>
                <input type="text" name="horacap" id="horacap" value="<?php if($obj->hora!=""){echo $obj->hora; } else {echo date('H:i');} ?>" class="ui-widget-content ui-corner-all text" style="width:60px; text-align:center" />
                
                <br />
                
                <label for="estado" class="labeless">N° de horas:</label>
                <input id="nrohoras" name="nrohoras" value="<?php echo $obj->nrohoras; ?>" onkeypress="return permite(event,'num_car');" class="text ui-widget-content ui-corner-all" style=" width: 50px; text-align: left;" />  
                
            </div>
            
        </div>
               
        <div id="tabs-2">
            <div id="dos">
            
                <label for="ref" class="labeless">Propuesta (Contenido):</label><br />
                <textarea name="propuesta" id="propuesta" style="width: 70%; margin-left:16%;" class="ui-widget-content ui-corner-all" cols="10" rows="5" ><?php echo $obj->propuesta; ?></textarea>
                <br />
                
                <label for="ref" class="labeless">Referencia Biblio.:</label><br />
                <textarea name="referencias" id="referencias" style="width: 70%; margin-left:16%;" class="text ui-widget-content ui-corner-all" cols="10" rows="3" ><?php echo $obj->referencias; ?></textarea>
                <br />
                
                <label for="ref" class="labeless">Palabras Claves:</label><br />
                <textarea name="palabrasclaves" id="palabrasclaves" style="width: 70%; margin-left:16%;" class="text ui-widget-content ui-corner-all" cols="10" rows="3" ><?php echo $obj->palabrasclaves; ?></textarea>
                <br />
            </div>
        </div>
        
        <div id="tabs-3">
            
            <div id="table-pers"> 
                        	            
            	<label for="destinatario" class="labels">Destinatario:</label>
            	<input id="personalasig" name="personalasig" value="<?php echo $obj->personalasig; ?>" onkeypress="return permite(event,'num_car');" class="text ui-widget-content ui-corner-all" style=" width: 250px; text-align: left;" />  
                <input type="hidden" name="idpersonalasig" id="idpersonalasig" value="" />

                <label for="objcap" class="labels">Tipo Alcance:</label> 
                <?php echo $tipoalc; ?><!--<input name="todos" id="todos" class="capacitacion" type="checkbox">&nbsp;Todos-->&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:" id="addDetails" class="fm-button ui-state-default ui-corner-all fm-button-icon-right ui-reset"><span class="ui-icon ui-icon-plusthick"></span>Agregar</a>
                    
            
            </div>

            <table id="table-detalles" class="ui-widget ui-widget-content" style="margin: 0 auto; width:440px" border="0" >
                <thead class="ui-widget ui-widget-content" >
                    <tr class="ui-widget-header" style="height: 23px">
                        <th align="center" width="200px">Destinatarios</th>
                        <th align="center" width="150px">Tipo Alcance</th>
                        <th width="20px">&nbsp;</th>
                    </tr>
                </thead>  
                <tbody>
                    <?php 
                        if(count($rowsA)>0)
                        {    
                            foreach ($rowsA as $id => $rs) 
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
        <div id="tabs-4">
            <div style="width:725px;">&nbsp;</div>
            <div id="queue" style="width:1px"></div>
            <input id="file_upload" name="file_upload" type="file" multiple="true">
            <input type="hidden" name="0form1_archivo" id="archivo" value="<?php echo $row['archivo'] ?>" />        
            <div class="ui-widget-content ui-corner-all">
                <table border="0" id="tabla-anexos" cellpadding="10" cellspacing="10" >
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </div>
        <div id="tabs-5">
            <div id="Presupuesto">
                
                <label for="destinatario" class="labeless">Categoria Presupuesto:</label>
                <?php echo $categoria; ?>
                <label for="objcap" class="labels">Conceptos:</label> 
                <select name="idconcepto" id="idconcepto" class="text ui-widget-content ui-corner-all">
                    <option value="0">.:: Seleccione ::.</option>
                </select>
                <br />

                <label for="cantidad" class="labeless">Cantidad:</label>
                <input type="text" id="cantidad" name="cantidad" value="1" class="text ui-widget-content ui-corner-all" style=" width: 40px; text-align: center;" />

                <label for="destinatario" class="labeless">Unidad de Medida:</label>
                <?php echo $unidadmed; ?>
                <input type="text" id="tiempo" name="tiempo" value="" class="text ui-widget-content ui-corner-all" style=" width: 65px; text-align: center;" placeholder="Tiempo" disabled />

                <label for="precio" class="labels">Precio:</label>
                <input type="text" id="precio" name="precio" value="1" class="text ui-widget-content ui-corner-all" style=" width: 50px; text-align: center;" />
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="javascript:" id="addDetPre" class="fm-button ui-state-default ui-corner-all fm-button-icon-right ui-reset"><span class="ui-icon ui-icon-plusthick"></span>Agregar</a>
                <br /><br />
                <table id="table-detpresupuesto" class="ui-widget ui-widget-content" style="margin: 0 auto; width:780px" border="0" >
                    <thead class="ui-widget ui-widget-content" >
                        <tr class="ui-widget-header" style="height: 23px">
                            <th align="center" width="200px">Categoria</th>
                            <th align="center" width="200px">Concepto</th>
                            <th align="center" width="25px">&nbsp;</th>
                            <th align="center" width="80px">Unidad</th>
                            <th align="center" width="70px">Cantidad</th>
                            <th align="center" width="80px">Precio Unit.</th>
                            <th align="center" width="60px">Sub Total</th>
                            <th width="20px">&nbsp;</th>
                        </tr>
                    </thead>  
                    <tbody>
                        <?php 
                            $total=0;
                            if(count($rowsP)>0)
                            {    
                                foreach ($rowsP as $id => $res) 
                                {   
                                    if($res['tiempo']==0){
                                        $res['tiempo']=0;
                                        $subtotal= ($res['preciounitario'] * $res['cantidad']);
                                        //$subtotal= $subtotal.toFixed(2);
                                    }else
                                        {
                                            $subtotal= ($res['preciounitario'] * $res['cantidad'] * $res['tiempo'] );
                                            //$subtotal= $subtotal.toFixed(2);
                                        }
                                        
                                        $total=$total+$subtotal;
                                    ?>
                                    <tr class="tr-detalle" style="height: 21px">
                                        <td align="left">
                                            <?php echo $res['categoria']; ?>                                       
                                            <input type="hidden" name="idcatpresupuestodet[]" value="<?php echo $res['idcatpresupuesto']; ?>" />
                                        </td>                                        
                                        <td>
                                            <?php echo $res['concepto']; ?>
                                            <input type="hidden" name="idconceptodet[]" value="<?php echo $res['idconcepto']; ?>" />
                                        </td>
                                        <td align="center">
                                            <?php echo $res['tiempo']; ?>
                                            <input type="hidden" name="tiempodet[]" value="<?php echo $res['tiempo']; ?>" />
                                        </td>
                                        <td align="center">
                                            <?php echo $res['unidad']; ?>
                                            <input type="hidden" name="idunidad_medidadet[]" value="<?php echo $res['idunidad_medida']; ?>" />
                                        </td>
                                        <td align="right">
                                            <?php echo $res['cantidad']; ?>
                                            <input type="hidden" name="cantidaddet[]" value="<?php echo $res['cantidad']; ?>" />
                                        </td>
                                        <td align="right">
                                            <?php echo $res['preciounitario']; ?>
                                            <input type="hidden" name="preciodet[]" value="<?php echo $res['preciounitario']; ?>" />
                                        </td>
                                        <td align="right">
                                            <?php echo number_format(($subtotal),2); ?>
                                            <input type="hidden" name="subtotal[]" value="<?php echo number_format(($subtotal),2); ?>" />
                                        </td>
                                        <td align="center"><a class="box-boton boton-deletesPre" href="#" title="Quitar" ></a></td>
                                    </tr>
                                    <?php    
                                    }  
                            }
                         ?>         
                    </tbody>
                    <!--<tfoot>
                        <tr class="tr-footer" style="height: 21px">                            
                            <td colspan="8">&nbsp;</td>
                        </tr>
                    </tfoot>-->
                    <tfoot>
                        <tr class="tr-footer" style="height: 21px">
                            <td colspan="5">&nbsp;</td>
                            <td align="right"><b>Total :&nbsp;&nbsp;&nbsp;</b></td>
                            <td align="right"><?php echo $total ?>&nbsp;</td>
                            <td colspan="5">&nbsp;</td>
                        </tr>

                    </tfoot>
                </table>
            
            </div>
        </div>
    </div>
</form>