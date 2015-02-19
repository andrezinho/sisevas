<script type="text/javascript">
    $(document).ready(function () {
        
    });
</script>

    <table id="list" class="ui-widget ui-widget-content" style="margin: 0 auto; width:700px" border="0" >
        <thead class="ui-widget ui-widget-content" >
            <tr class="ui-widget-header" style="height: 23px">          
                <th align="center" width="220">Codigo</th>                
                <th align="center" width="120">Asunto</th>
                <th align="center" width="120">Fecha</th>
                <th align="center" width="120">Remitente</th>               
            </tr>
        </thead>  
        <tbody>
            <?php 
                if(count($rowsd)>0)
                {
                    foreach ($rowsd as $i => $r) 
                    {
                                                                     
                        ?>
                        <tr class="tr-detalle" style="height: 23px;">
                            <td align="left"><?php echo $r['obj']; ?></td>                        
                        
                            <?php
                                foreach ($r['det'] as $f => $d) 
                                {
                            ?>                     
                            <td align="left"><?php echo $d['descripcion']; ?></td>
                            <?php                                
                                }
                            ?> 
                        </tr>
                            <?php
                                foreach ($r['det'] as $f => $d) 
                                {
                            ?> 
                            <tr>                                
                                <td align="left"><?php echo $d['nro']; ?></td>
                            </tr>
                            <?php                                
                                }
                            ?>                                                     
                        
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
            </tr>
            
        </tfoot>
    </table>

<br />