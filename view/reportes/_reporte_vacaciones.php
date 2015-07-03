<fieldset class="resport">
    <legend>Resultados de la Consulta</legend>
    <table id="table-detalle" class="ui-widget ui-widget-content" style="margin: 0 auto; width:900px" border="0" >
        <thead class="ui-widget ui-widget-content" >
            <tr class="ui-widget-header" style="height: 23px">          
                <th align="center" width="50">Codigo</th>                
                <th align="center" width="220">Tema</th>
                <th align="center" width="60">Fecha</th>
                <th align="center" width="200">Expositor</th>
                <th align="center" width="60">Estado</th>                
            </tr>
        </thead>  
        <tbody>
            <?php 
                if(count($rows)>0)
                {   
                    $tc= count($rows);
                    
                    foreach ($rows as $i => $r) 
                    {
                        
                        $fec= split('-', $r['fecha']);
                       
                        switch ($r['estado']) {
                            case 0:
                                $est='<p style="color:orange;font-weight: bold;">Falta Asignar</p>'; break;
                                //$e1++;
                            case 1:
                                $est='<p style="color:red;font-weight: bold;">En Proceso</p>'; break;
                                //$e2++;
                            case 2:
                                $est='<p style="color:green;font-weight: bold;">Finalizado</p>'; break;
                                //$e3++;                      
                        
                        }
                        
                        ?>
                        <tr class="tr-detalle" style="height: 21px;">
                            <td align="center"><?php echo (strtoupper($r['codigo'])); ?></td>
                            <td align="left"><?php echo (strtoupper($r['tema'])); ?></td>
                            <td align="center"><?php echo $fec[2]."/".$fec[1]."/".$fec[0]; ?></td>
                            <td><?php echo (strtoupper($r['expositor'])); ?></td> 
                            <td align="left">
                                <?php echo $est; ?>
                            </td>                                                       
                        </tr>                        
                        <?php    
                    }
                    ?>
                    
                    <tr>
                        <td colspan="5">
                            <?php
                                $es1=0; $es2=0; $es3=0;
                                foreach ($rows as $i => $rs) 
                                {
                                    if($rs['estado']==0)
                                    {
                                        $es1++;
                                    }
                                    if($rs['estado']==1)
                                    {
                                        $es2++;
                                    }
                                    if($rs['estado']==2)
                                    {
                                        $es3++;
                                    }
                                    /*switch ($rs['estado']) {
                                        case 0:                                            
                                            $es1++;
                                        case 1:                                            
                                            $es2++;
                                        case 2:                                            
                                            $es3++;
                                    }*/
                                }
                            ?>
                            <label for="dni" class="labeless">Total de cap.:</label><?php echo $tc; ?><br/>
                            <label for="dni" class="labeless">Cap. Asignada:</label><?php echo $es1; ?><br/>
                            <label for="dni" class="labeless">Cap. en Proc.:</label><?php echo $es2; ?><br/>
                            <label for="dni" class="labeless">Cap. Finaliz.:</label><?php echo $es3; ?><br/>
                        </td>
                    </tr>                     
                   <?php
                }
             ?>                      
        </tbody>
         <tfoot>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            
        </tfoot>
    </table>
       
</fieldset>
<br />
<br />