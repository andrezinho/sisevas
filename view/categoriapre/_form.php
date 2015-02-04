<?php  include("../lib/helpers.php"); 
       include("../view/header_form.php");
       
?>
<div style="padding:10px 20px">
<form id="frm_cat" >
    <input type="hidden" name="controller" value="categoriapre" />
    <input type="hidden" name="action" value="save" /> 

    <input type="hidden" id="idcatpresupuesto" name="idcatpresupuesto" value="<?php echo $obj->idcatpresupuesto; ?>" />
    <br/>           
    <label for="descripcion" class="labels">Descripcion:</label>
    <input type="text" id="descripcion" maxlength="100" name="descripcion" onkeypress="return permite(event,'car');" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->descripcion; ?>" />
    <br/>
    <br/>
    <div id="asignacion">
        <fieldset class="fieldset">
            <legend class="legend">Asignacion de Conceptos</legend>
            <label for="descripcion" class="labeless">Buscar conceptos:</label>
            <input type="text" id="concepto" maxlength="100" name="concepto" onkeypress="return permite(event,'car');" class="text ui-widget-content ui-corner-all" style=" width: 350px; text-align: left;" value="" />
            <input type="hidden" id="idconcepto" name="idconcepto" value="" />
            
            <a href="javascript:" id="addDetail" class="fm-button ui-state-default ui-corner-all fm-button-icon-right ui-reset"><span class="ui-icon ui-icon-plusthick"></span>Agregar</a>
            <br/><br/>
            <table id="table-detalle" class="ui-widget ui-widget-content" style="margin: 0 auto; width:440px" border="0" >
                <thead class="ui-widget ui-widget-content" >
                    <tr class="ui-widget-header" style="height: 23px">          
                        <th align="center" width="620px">Concepto</th>
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
                                    <td align="left"><?php echo $r['descripcion']; ?><input type="hidden" name="idconceptodet[]" value="<?php echo $r['idconcepto']; ?>" /></td>
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
        </fieldset>
    </div>
    
    <label for="estado" class="labels">Estado:</label>
    <div id="estados" style="display:inline">
        <?php                   
            if($obj->estado==1 || $obj->estado==0)
            {
                if($obj->estado==1){$rep=1;}
                else {$rep=0;}
            }
            else {$rep = 1;}                    
                activo('activo',$rep);
        ?>
    </div>
</form>
</div>