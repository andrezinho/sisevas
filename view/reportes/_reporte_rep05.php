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
                    foreach ($rows as $i => $r) 
                    {       
                        
                        $fec= split('-', $r['fecha']);
                        
                        switch ($r['estado']) {
                            case 0:
                                $est='Falta Asignar'; break;
                            case 1:
                                $est='En Proceso'; break;
                            case 2:
                                $est='Finalizado'; break;                       
                        
                        }
                        
                        ?>
                        <tr class="tr-detalle">
                            <td align="center"><?php echo (strtoupper($r['codigo'])); ?></td>
                            <td align="left"><?php echo (strtoupper($r['tema'])); ?></td>
                            <td align="center"><?php echo $fec[2]."/".$fec[1]."/".$fec[0]; ?></td>
                            <td><?php echo (strtoupper($r['expositor'])); ?></td> 
                            <td align="center">
                                <?php echo $est; ?>
                            </td>                                                       
                        </tr>
                        <?php    
                        }  
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