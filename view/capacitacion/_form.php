<?php  include("../lib/helpers.php"); 
       include("../view/header_form.php");
?>
   
<form id="frm_cap" >
    <input type="hidden" name="controller" value="capacitacion" />
    <input type="hidden" name="action" value="save" />
    <input type="hidden" id="idcapacitacion" name="idcapacitacion" value="<?php echo $obj->idcapacitacion; ?>" />
    
    <div id="tabs">
        <ul style="background:#DADADA !important; border:0 !important">
            <li><a href="#tabs-1">Informaci&oacute;n B&aacute;sica</a></li>
            <li><a href="#tabs-2">Costos</a></li>
            <li><a href="#tabs-3">Anexos</a></li>
        </ul>
        <div id="tabs-1">
            <div id="table-per">
            
                <label for="fuente" class="labeless">Fuente de cap.:</label> 
                <?php echo $fuente; ?>
                
                <label for="eje" class="labeless">Eje de capac.:</label> 
                <?php echo $eje; ?>
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
                                    $nro= $r['nromeses'];
                                    $men= $r['cuota'];                                        
                                    $ini= $r['inicial'];
                                    $subt= (floatval($nro) * floatval($men))+ $ini;
                                        
                                    ?>
                                    <tr class="tr-detalle">
                                        <td align="left"><?php echo $r['descripcion']; ?><input type="hidden" name="idtipopago[]" value="<?php echo $r['tipo']; ?>" /></td>
                                        <td>&nbsp;</td>
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
                <label for="ref" class="labeless">Referencia Biblio.:</label><br />
                <textarea name="referencias" id="referencias" style="width: 70%; margin-left:16%;" class="text ui-widget-content ui-corner-all" cols="10" rows="4" ><?php echo $obj->referencias; ?></textarea>
                <br />
                
                <label for="ref" class="labeless">Palabras Claves:</label><br />
                <textarea name="palabrasclaves" id="palabrasclaves" style="width: 70%; margin-left:16%;" class="text ui-widget-content ui-corner-all" cols="10" rows="4" ><?php echo $obj->palabrasclaves; ?></textarea>
                <br />
                
                <label for="estado" class="labeless">Expositor:</label>
                <input id="expositor" name="expositor" onkeypress="return permite(event,'num_car');" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->expositor; ?>" />    
                <input type="hidden" id="idpersonal" name="idpersonal" value="<?php echo $obj->idpersonal; ?>" />
                
                <label for="estado" class="labeless">Email Exposit.:</label>
                <input id="emailexp" name="emailexp" onkeypress="return permite(event,'num_car');" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->emailexp; ?>" />  
                
            </div>
        </div>
        
        <div id="tabs-2">
        </div>
        <div id="tabs-3">
            
            <label for="anex" class="labeless">Anexo:</label>
            <input id="anexo" name="anexo" onkeypress="return permite(event,'num_car');" class="text ui-widget-content ui-corner-all" style=" width: 190px; text-align: left;" value="<?php echo $obj->anexo; ?>" />    
            <br />
            
        </div>
    </div>
    
    
</form>
