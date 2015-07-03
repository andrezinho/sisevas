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
            $destp='Lineas de Acción / Objetivos de la empresa'; break;
        case 2:
            $destp='Lineas de Acción / Objetivos de la capacitación'; break;
        case 3:
            $destp='Lineas de Accion / Tiempo de Dedicación'; break;
    }
    
    
    if($tp==1)
    {
    ?>   
        <fieldset class="resport2">
            <legend>Resultados de la Consulta</legend>
            <table id="list" class="ui-widget ui-widget-content" style="margin: 0 auto; width:850px" border="0" >
                <thead class="ui-widget ui-widget-content" >
                    <tr class="ui-widget-header" style="height: 23px">          
                        <th align="center" width="160"><?php echo $destp;?></th>                
                        <th align="center" width="110">Impulsar acciones de Salud Comunitaria en base a paquetes de atenci&oacute;n</th>
                        <th align="center" width="110">Fortalecer  la orientaci&oacute;n y consejer&iacute;a del consultorio de GO</th>
                        <th align="center" width="110">Mantener el programa de calidad implementada por la SGS</th>
                        <th align="center" width="110">Fortalecer  el programa de inversiones de la empresa</th>
                        <th align="center" width="110">Desarrollo de un sistema de captaci&oacute;n de clientes</th>
                        <th align="center" width="110">Promover el desarrollo de las competencias del RRHH</th> 
                        <th align="center" width="30">&nbsp;</th> 
                    </tr>
                </thead>  
                <tbody>
                    <?php 
                        if(count($rows)>0)
                        {   
                            $tr1=0;$tr2=0;$tr3=0;$tr4=0;$tr5=0;$tr6=0;
                            foreach ($rows as $i => $r) 
                            {   
                                $tr1= $tr1+$r[1];
                                $tr2= $tr2+$r[2];
                                $tr3= $tr3+$r[3];
                                $tr4= $tr1+$r[4];
                                $tr5= $tr2+$r[5];
                                $tr6= $tr3+$r[6];
                                $tf= $tr1+$tr2+$tr3+$tr4+$tr5+$tr6;
                                ?>
                                <tr class="tr-detalle" style="height: 23px;">
                                    <td align="left"><?php echo $r[0]; ?></td>
                                    <td align="center"><?php echo $r[1]; ?></td>
                                    <td align="center"><?php echo $r[2]; ?></td>
                                    <td align="center"><?php echo $r[3]; ?></td>
                                    <td align="center"><?php echo $r[4]; ?></td>
                                    <td align="center"><?php echo $r[5]; ?></td>
                                    <td align="center"><?php echo $r[6]; ?></td>
                                    <td align="center" style="font-size: 13px; font-weight: bold;"><?php echo ($r[1]+$r[2]+$r[3]+$r[4]+$r[5]+$r[6]); ?></td>
                                </tr>                         
                                <?php
                            }                    
                        }
                     ?>                      
                </tbody>
                 <tfoot>
                    <tr style="font-size: 13px; font-weight: bold; height: 23px;">
                        <td align="right">Total :</td>
                        <td align="center"><?=$tr1;?></td>
                        <td align="center"><?=$tr2;?></td>
                        <td align="center"><?=$tr3;?></td>
                        <td align="center"><?=$tr4;?></td>
                        <td align="center"><?=$tr5;?></td>
                        <td align="center"><?=$tr6;?></td>
                        <td align="center"><?=$tf;?></td>
                    </tr>
                    
                </tfoot>
            </table>
            
        </fieldset>
        <br />
    <?php   
    }
    
    if($tp==2)
    {
    ?>   
        <fieldset class="resport2">
            <legend>Resultados de la Consulta</legend>
            <table id="list" class="ui-widget ui-widget-content" style="margin: 0 auto; width:850px" border="0" >
                <thead class="ui-widget ui-widget-content" >
                    <tr class="ui-widget-header" style="height: 23px">          
                        <th align="center" width="190"><?php echo $destp;?></th>                
                        <th align="center" width="110">Desarrollar aptitudes, habilidades y destrezas en el personal seg&uacute;n el &aacute;rea de trabajo proporcionando</th>
                        <th align="center" width="110">Fortalecer los est&aacute;ndares de calidad en los servicios para mantener las BPMG</th>
                        <th align="center" width="110">Lograr cambios en el comportamiento del personal con el fin de contribuir a la mejora de las relaciones</th>
                        <th align="center" width="110">Desarrollar el perfil del capacitador y supervisor del establecimiento</th>
                        <th align="center" width="110">Optimizar los recursos financieros de la Empresa / Incrementar la productividad</th>
                        <th align="center" width="110">Promover un mayor ambiente de seguridad en el trabajo</th>         
                    </tr>
                </thead>  
                <tbody>
                    <?php 
                        if(count($rows)>0)
                        {   
                            $tr1=0;$tr2=0;$tr3=0;$tr4=0;$tr5=0;$tr6=0;
                            foreach ($rows as $i => $r) 
                            {   
                                $tr1= $tr1+$r[1];
                                $tr2= $tr2+$r[2];
                                $tr3= $tr3+$r[3];
                                $tr4= $tr4+$r[4];
                                $tr5= $tr5+$r[5];
                                $tr6= $tr6+$r[6];
                                $tf= $tr1+$tr2+$tr3+$tr4+$tr5+$tr6;
                                ?>
                                <tr class="tr-detalle" style="height: 23px;">
                                    <td align="left"><?php echo $r[0]; ?></td>
                                    <td align="center"><?php echo $r[1]; ?></td>
                                    <td align="center"><?php echo $r[2]; ?></td>
                                    <td align="center"><?php echo $r[3]; ?></td>
                                    <td align="center"><?php echo $r[4]; ?></td>
                                    <td align="center"><?php echo $r[5]; ?></td>
                                    <td align="center"><?php echo $r[6]; ?></td>
                                    <!--<td align="center"><?php echo ($r[1]+$r[2]+$r[3]); ?></td>-->
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
                        <td align="center"><?=$tr4;?></td>
                        <td align="center"><?=$tr5;?></td>
                        <td align="center"><?=$tr6;?></td>
                    </tr>
                    
                </tfoot>
            </table>
            
        </fieldset>
        <br />
    <?php   
    }
    
    if($tp==3)
    {
    ?>   
        <fieldset class="resport2">
            <legend>Resultados de la Consulta</legend>
            <table id="list" class="ui-widget ui-widget-content" style="margin: 0 auto; width:850px" border="0" >
                <thead class="ui-widget ui-widget-content" >
                    <tr class="ui-widget-header" style="height: 23px">
                        <th align="center" width="190"><?php echo $destp;?></th>
                        <th align="center" width="110">Asistencial / Medico</th>
                        <th align="center" width="110">Preventivo Promocional / Salud Comunitaria</th>
                        <th align="center" width="110">Gestion</th>
                        <th align="center" width="110">Investigacion</th>
                        <th align="center" width="110">Administrativo</th>
                    </tr>
                </thead>  
                <tbody>
                    <?php 
                        if(count($rows)>0)
                        {   
                            $tr1=0;$tr2=0;$tr3=0;$tr4=0;$tr5=0;$tr6=0;
                            foreach ($rows as $i => $r) 
                            {   
                                $tr1= $tr1+$r[1];
                                $tr2= $tr2+$r[2];
                                $tr3= $tr3+$r[3];
                                $tr4= $tr4+$r[4];
                                $tr5= $tr5+$r[5];
                                $tr6= $tr6+$r[6];
                                $tf= $tr1+$tr2+$tr3;
                                ?>
                                <tr class="tr-detalle" style="height: 23px;">
                                    <td align="left"><?php echo $r[0]; ?></td>
                                    <td align="center"><?php echo $r[1]; ?></td>
                                    <td align="center"><?php echo $r[2]; ?></td>
                                    <td align="center"><?php echo $r[3]; ?></td>
                                    <td align="center"><?php echo $r[4]; ?></td>
                                    <td align="center"><?php echo $r[5]; ?></td>
                                    <!--<td align="center"><?php echo $r[6]; ?></td>
                                    </a><td align="center"><?php echo ($r[1]+$r[2]+$r[3]); ?></td>-->
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
                        <td align="center"><?=$tr4;?></td>
                        <td align="center"><?=$tr5;?></td>
                        <!--<td align="center"><?=$tr6;?></td>-->
                    </tr>
                    
                </tfoot>
            </table>
            
        </fieldset>
        <br />
    <?php   
    }