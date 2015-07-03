<script type="text/javascript">
    $(document).ready(function () {
        $("#list").on('click', '.printer', function() {
            var i = $(this).attr("id");
            i = i.split('-');
            id = i[1];
            td = i[2];
            idper= i[3];
            //alert(id);
            if(td== 2 || td== 3)
            {
                var ventana=window.open('index.php?controller=recepcion&action=printer_ot&id='+id+'&idper='+idper, 'scrollbars=yes, status=yes,location=yes'); 
                ventana.focus();
            }        
            
            if(td== 1)
            {
                var ventana=window.open('index.php?controller=recepcion&action=printer_mem&id='+id+'&idper='+idper, 'scrollbars=yes, status=yes,location=yes'); 
                ventana.focus();
            }
            
            if(td== 4)
            {
                var ventana=window.open('index.php?controller=recepcion&action=printer_cartfec&id='+id+'&idper='+idper, 'scrollbars=yes, status=yes,location=yes'); 
                ventana.focus();
            }
            
            if(td== 5)
            {
                var ventana=window.open('index.php?controller=recepcion&action=printer_cartcum&id='+id+'&idper='+idper, 'scrollbars=yes, status=yes,location=yes'); 
                ventana.focus();
            }  
            
            if(td== 10 || td== 11 || td== 12)
            {
                var ventana=window.open('index.php?controller=recepcion&action=printer_actareu&id='+id+'&idper='+idper+'&idtpdoc='+td, 'scrollbars=yes, status=yes,location=yes'); 
                ventana.focus();
            }
            
        });
    });
</script>
<?php 
    $idpersonal= $_GET['idp'];
    $idtpd= $_GET['idtipo_documento'];
    
    if($idpersonal==0 && $idtpd=='')
    {
        
        
?>
<fieldset class="resport">
    <legend>Resultados de la Consulta</legend>
    <table id="list" class="ui-widget ui-widget-content" style="margin: 0 auto; width:500px" border="0" >
        <thead class="ui-widget ui-widget-content" >
            <tr class="ui-widget-header" style="height: 23px">          
                <th align="center" width="220">Tipo Documento</th>                
                <th align="center" width="70">N°</th>
                <th align="center" width="60">%</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            //print_r($rows);
                if(count($rows)>0)
                {   
                    $tot=0;
                    foreach ($rows as $i => $r) 
                    {$tot= $tot+$r['nro'];}
                    
                    foreach ($rows as $i => $r) 
                    {
                        
                        ?>
                        <tr class="tr-detalle" style="height: 23px;">
                            <td align="left"><?php echo (strtoupper($r['descripcion'])); ?></td>
                            <td align="right"><?php echo $r['nro']; ?></td>
                            <td align="right"><?php echo number_format(($r['nro']*100)/$tot, 2); ?></td>                                                                                                             
                        </tr>
                        <?php
                    }                    
                }
             ?>                      
        </tbody>
        <tfoot>
            <tr>
                <td align="right">Total :</td>
                <td align="right"><?=$tot;?></td>
                <td align="right">100</td>                
            </tr>
            
        </tfoot>
    </table>
    
</fieldset>
<?php
    }else
    {
?>
<fieldset class="resport">
    <legend>Resultados de la Consulta</legend>
    <table id="list" class="ui-widget ui-widget-content" style="margin: 0 auto; width:900px" border="0" >
        <thead class="ui-widget ui-widget-content" >
            <tr class="ui-widget-header" style="height: 23px">          
                <th align="center" width="70">Codigo</th>                
                <th align="center" width="220">Asunto</th>
                <th align="center" width="60">Fecha</th>
                <th align="center" width="200">Remitente</th>
                <th align="center" width="60">Ver</th>                
            </tr>
        </thead>  
        <tbody>
            <?php 
                if(count($rows)>0)
                {    
                    foreach ($rows as $i => $r) 
                    {
                        $fec= split('-', $r['fechainicio']);
                                                
                        ?>
                        <tr class="tr-detalle" style="height: 23px;">
                            <td align="center"><?php echo (strtoupper($r['codigo'])); ?></td>
                            <td align="left"><?php echo (strtoupper($r['asunto'])); ?></td>
                            <td align="center"><?php echo $fec[2]."/".$fec[1]."/".$fec[0]; ?></td>
                            <td><?php echo (strtoupper($r['remitente'])); ?></td> 
                            <td align="center">
                                <?php
                                    if($idpersonal!=0)
                                    {
                                ?>
                                <a class="printer box-boton boton-recibido" id="f-<?php echo $r[0]; ?>-<?php echo $r[1]; ?>-<?php echo $r[2]; ?>" href="#" title="Ver Documento" ></a>
                                <?php
                                    }
                                ?>

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
<?php
    }
?>