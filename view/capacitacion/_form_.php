<?php  
    include("../lib/helpers.php"); 
    include("../view/header_form.php");       
    
?>
   
<form id="frm_cap" >
    <input type="hidden" name="controller" value="capacitacion" />
    <input type="hidden" name="action" value="save" />
    <input type="hidden" id="idcapacitacion" name="idcapacitacion" value="<?php echo $obj->idcapacitacion; ?>" />
    
    <div id="tabs">
        <ul style="background:#DADADA !important; border:0 !important">
            <li><a href="#tabs-1">Informaci&oacute;n B&aacute;sica</a></li>
            <li><a href="#tabs-2">Propuesta</a></li>
            <!--<li><a href="#tabs-2">Costos</a></li>
            <li><a href="#tabs-3">Anexos</a></li>-->
        </ul>
        <div id="tabs-1">
            <div id="table-per">
                
                <label for="cod" class="labeless">Codigo:</label>
                <input type="text" id="correlativo" name="correlativo" class="text ui-widget-content ui-corner-all" style=" width: 100px; text-align: left;" value="<?php echo $obj->codigo; ?>" readonly="">
                <input type="hidden" id="codigo" name="codigo"  value="<?php echo $obj->codigo; ?>" />
                <br />
                
                <label for="tem" class="labeless">Tema:</label>
                <input id="tema" name="tema" onkeypress="return permite(event,'num_car');" class="text ui-widget-content ui-corner-all" style=" width: 520px; text-align: left;" value="<?php echo $obj->tema; ?>" />
                <br />
                
                <label for="tem" class="labeless">Acuerdo:</label>
                <input id="tema" name="tema" onkeypress="return permite(event,'num_car');" class="text ui-widget-content ui-corner-all" style=" width: 520px; text-align: left;" value="<?php echo $obj->tema; ?>" />
                <br />
                
                <label for="objemp" class="labeless">Personal Asist:</label> 
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
                                        <td align="left"><?php echo $r['descripcion']; ?><input type="hidden" name="idobejtivosempresa[]" value="<?php echo $r['idobejtivosemp']; ?>" /></td>
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
                
                <label for="hora" class="labels">Hora Inicio:</label>
                <input type="text" name="horacap" id="horacap" value="<?php if($obj->hora!=""){echo $obj->hora; } else {echo date('H:i');} ?>" class="ui-widget-content ui-corner-all text" style="width:60px; text-align:center" />
                
                <label for="hora" class="labels">Hora Final:</label>
                <input type="text" name="horacap" id="horacap" value="<?php if($obj->hora!=""){echo $obj->hora; } else {echo date('H:i');} ?>" class="ui-widget-content ui-corner-all text" style="width:60px; text-align:center" />
                
                
            </div>
            
        </div>
                
        <div id="tabs-2">
            <div id="dos">
            
                <label for="ref" class="labeless">Propuesta :</label><br />
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
        
        
    </div>
    
    
</form>
