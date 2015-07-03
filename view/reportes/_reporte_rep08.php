<style type="text/css">
.resport2{
    margin: auto;
    /*width: 850px;*/
    border: 2px solid #004B75;
    -moz-border-radius: 1em 1em 1em 1em;
    border-radius: 1em 1em 1em 1em;
}

.resport2 legend {
font-size: 12px;
color: #ffffff;
padding: 5px;
background: #004B75;
-moz-border-radius: 1em 1em 1em 1em;
border-radius: 1em 1em 1em 1em;
}
</style>
<?php
    
    $tp=$_GET['tp'];
    switch ($tp) {
        case 1:
            $destp=utf8_encode('Objetivos de Capacitación / Cat. de Presupuesto'); break;
        case 2:
            $destp=utf8_encode('Eje de Capacitación / Cat. de Presupuesto'); break;
        case 3:
            $destp=utf8_encode('Personal / Cat. de Presupuesto'); break;
        case 4:
            $destp=utf8_encode('Objetivos de la empresa / Cat. de Presupuesto'); break;
        case 5:
            $destp=utf8_encode('Lineas de Acción / Cat. de Presupuesto'); break;
    }
?>
<fieldset class="resport2">
    <legend>Resultados de la Consulta</legend>
    <table id="list" class="ui-widget ui-widget-content" style="margin: 0 auto; width:780px" border="0" >
        <thead class="ui-widget ui-widget-content" >
            <tr class="ui-widget-header" style="height: 23px; font-size:12px;">          
                <th align="center" width="400"><?php echo $destp;?></th>                
                <th align="center" width="80">Subvencion a Investigadores</th>
                <th align="center" width="80">Supervisi&oacute;n y monitoreo</th>
                <th align="center" width="80">Bienes y Servicios</th>
                <th align="center" width="80">Equipamiento</th>
                <th align="center" width="60">Total</th>         
            </tr>
        </thead>  
        <tbody>
            <?php 
                if(count($rows)>0)
                {   
                    $tr1=0;$tr2=0;$tr3=0;$tr4=0;
                    foreach ($rows as $i => $r) 
                    {   
                        $tr1= $tr1+$r[1];
                        $tr2= $tr2+$r[2];
                        $tr3= $tr3+$r[3];
                        $tr4= $tr4+$r[4];
                        $tf= $tr1+$tr2+$tr3+$tr4;
                        ?>
                        <tr class="tr-detalle" style="height: 23px; font-size:12px;">
                            <td align="left"><?php echo $r[0]; ?></td>
                            <td align="right"><?php echo number_format($r[1],2); ?></td>
                            <td align="right"><?php echo number_format($r[2],2); ?></td>
                            <td align="right"><?php echo number_format($r[3],2); ?></td>
                            <td align="right"><?php echo number_format($r[4],2); ?></td>
                            <td align="right"><?php echo number_format(($r[1]+$r[2]+$r[3]+$r[4]),2); ?></td>
                        </tr>                         
                        <?php
                    }                    
                }
             ?>                      
        </tbody>
         <tfoot>
            <tr style="height: 23px;">
                <td align="right">Total :</td>
                <td align="right"><?=number_format($tr1,2);?></td>
                <td align="right"><?=number_format($tr2,2);?></td>
                <td align="right"><?=number_format($tr3,2);?></td>
                <td align="right"><?=number_format($tr4,2);?></td>
                <td align="right"><?=number_format($tf,2);?></td>
            </tr>
            
        </tfoot>
    </table>
    
</fieldset>
<br />
<br />