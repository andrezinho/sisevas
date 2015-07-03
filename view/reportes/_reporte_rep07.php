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
            $destp=utf8_encode('Objetivos de Capacitación / Tipo alcance'); break;
        case 2:
            $destp=utf8_encode('Eje de Capacitación / Tipo alcance'); break;
        case 3:
            $destp=utf8_encode('Personal / Tipo alcance'); break;
        case 4:
            $destp=utf8_encode('Objetivos de la empresa / Tipo alcance'); break;
        case 5:
            $destp=utf8_encode('Lineas de Acción / Tipo alcance'); break;
    }
?>
<fieldset class="resport2">
    <legend>Resultados de la Consulta</legend>
    <table id="list" class="ui-widget ui-widget-content" style="margin: 0 auto; width:700px" border="0" >
        <thead class="ui-widget ui-widget-content" >
            <tr class="ui-widget-header" style="height: 23px">          
                <th align="center" width="410"><?php echo $destp;?></th>                
                <th align="center" width="80">Planificado</th>
                <th align="center" width="80">Obligatorio</th>
                <th align="center" width="80">Voluntario</th>
                <th align="center" width="50">Total</th             
            </tr>
        </thead>  
        <tbody>
            <?php 
                if(count($rows)>0)
                {   
                    $tr1=0;$tr2=0;$tr3=0;
                    foreach ($rows as $i => $r) 
                    {   
                        $tr1= $tr1+$r[1];
                        $tr2= $tr2+$r[2];
                        $tr3= $tr3+$r[3];
                        $tf= $tr1+$tr2+$tr3;
                        ?>
                        <tr class="tr-detalle" style="height: 23px;">
                            <td align="left"><?php echo $r[0]; ?></td>
                            <td align="center"><?php echo $r[1]; ?></td>
                            <td align="center"><?php echo $r[2]; ?></td>
                            <td align="center"><?php echo $r[3]; ?></td>
                            <td align="center"><?php echo ($r[1]+$r[2]+$r[3]); ?></td>
                        </tr>                         
                        <?php
                    }                    
                }
             ?>                      
        </tbody>
         <tfoot>
            <tr style="height: 23px;">
                <td align="right">Total :</td>
                <td align="center"><?=$tr1;?></td>
                <td align="center"><?=$tr2;?></td>
                <td align="center"><?=$tr3;?></td>
                <td align="center"><?=$tf;?></td>
            </tr>
            
        </tfoot>
    </table>
    
</fieldset>
<br />
<br />