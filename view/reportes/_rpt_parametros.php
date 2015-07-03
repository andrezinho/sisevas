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
            $destp=utf8_encode('PERSONAL / COMPETENCIAS'); 
            $des=$dat1[1];
            break;            
        case 2:
            $destp=utf8_encode('PERSONAL / ASPECTOS'); 
            $des=$dat1[4];
            $ptm= $dat1[5];
            break;
        
    }
?>
<fieldset class="resport2">
    <legend>Resultados de la Consulta</legend>
    <table id="list" class="ui-widget ui-widget-content" style="margin: 0 auto; width:700px" border="0" >
        <thead class="ui-widget ui-widget-content" >
            <tr class="ui-widget-header" style="height: 23px; font-size:12px;"> 
                <th align="center" width="40">N°</th> 
                <th align="center" width="300"><?php echo $destp;?></th>                
                <th align="center" width="250"><?php echo $des;?></th>
                <th align="center" width="70">%</th>         
            </tr>
        </thead>  
        <tbody>
            <?php 
                $idcomp= $dat1[0];
                $idasp= $dat1[3];
                if(count($rows)>0)
                {   
                    if($idasp== '')
                    {
                        switch ($idcomp) {
                            case 1:
                                $ptm=110;break;                            
                            case 2:
                                $ptm=105; break;
                            case 3:
                                $ptm=100; break;
                            case 4:
                                $ptm=100; break;
                        }
                    }
                    
                    $cc=1;
                    $tr1=0;$td=0;
                    
                    foreach ($rows as $i => $r) 
                    {   
                        $td= ($r[1]*100)/$ptm;
                        $tr1= $tr1+ $r[1];
                        
                        ?>
                        <tr class="tr-detalle" style="height: 23px; font-size:12px;">
                            <td align="center"><?php echo $cc++; ?></td>
                            <td align="left"><?php echo $r[0]; ?></td>
                            <td align="right"><?php echo number_format($r[1],0); ?></td>
                            <td align="right"><?php echo number_format($td,0); ?></td>
                        </tr>                         
                        <?php
                    }                    
                }
             ?>                      
        </tbody>
         <tfoot>
            <tr style="height: 23px;font-size:13px; font-weight: bold;">
                <td align="right" colspan="2">Puntaje M&aacute;ximo :</td>
                <td align="right"><?=number_format($ptm,0);?></td>
                <td align="right">100%</td>
            </tr>
            
        </tfoot>
    </table>
    
</fieldset>
<br />
<br />