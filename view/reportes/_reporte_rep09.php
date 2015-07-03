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
            $destp='Fuentes de Capacitación'; break;
        case 2:
            $destp='Lineas de Ación'; break;
        case 3:
            $destp='Metodo de Capacitación'; break;
        case 4:
            $destp='Tiempo de Dedicación'; break;
        case 5:
            $destp='Tipo de Alcance'; break;
    }
?>
<fieldset class="resport2">
    <legend>Resultados de la Consulta</legend>
    <table id="list" class="ui-widget ui-widget-content" style="margin: 0 auto; width:580px" border="0" >
        <thead class="ui-widget ui-widget-content" >
            <tr class="ui-widget-header" style="height: 23px; font-size:12px;">          
                <th align="center" width="400"><?php echo $destp;?></th>                
                <th align="center" width="80">N&deg;</th>
                <th align="center" width="80">%</th>         
            </tr>
        </thead>  
        <tbody>
            <?php 
                //print_r($tt);
                if(count($rows)>0)
                {   
                    
                    $tr1=0;$$td=0;
                    $tt =$tt[0];
                    
                    foreach ($rows as $i => $r) 
                    {   
                        $tr1= $tr1+$r[1];                        
                        $td= ($r[1]*100)/$tt;
                        ?>
                        <tr class="tr-detalle" style="height: 23px; font-size:12px;">
                            <td align="left"><?php echo $r[0]; ?></td>
                            <td align="right"><?php echo $r[1]; ?></td>
                            <td align="right"><?php echo number_format($td,2); ?></td>
                        </tr>                         
                        <?php
                    }                    
                }
             ?>                      
        </tbody>
         <tfoot>
            <tr style="height: 23px;font-size:12px;">
                <td align="right">Total :</td>
                <td align="right"><?=$tr1;?></td>
                <td align="right"><?=number_format('100');?></td>
            </tr>
            
        </tfoot>
    </table>
    
</fieldset>
<br />
<br />