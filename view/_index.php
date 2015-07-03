<div class="div_container">
<!-- <h6 class="ui-widget-header ui-state-hover">&nbsp;</h6>-->
	
    <div class="contain-left">
        <!--<p class="titleind"><strong><a href="">MISI&Oacute;N</a></strong></p>
        <p class="titleind"><strong><a href="">VISI&Oacute;N</strong></a></p>
        <p class="titleind"><strong><a href="">ORGANIGRAMA</strong></a></p>-->
        <br /><br />
        <img border="0" src="images/Leyendo.gif" width="150" height="150" />
    </div>
    <div class="contain-der">
               
        <div id="tabsindex" class="tabsindex">
            <ul>
                <li><a href="#tab-1">MISI&Oacute;N Y VISI&Oacute;N</a></li>
                <li><a href="#tab-2">OBJETIVOS DE LA EMPRESA</a></li>
                <li><a href="#tab-3">OBJETIVOS DE LA CALIDAD</a></li>
                <li><a href="#tab-4">OBJETIVOS DE LA CAPACITACI&Oacute;N</a></li>
                <li><a href="#tab-5">VALORES</a></li>
                <li><a href="#tab-6">POL&IacuteTICA DE CALIDAD</a></li>
            </ul>
            <div class="tabscontent">
                <div id="tab-1">
                    <div class="content">
                        <div style="float: left;">
                            <h3 class="titleind">Misi&oacute;n</h3>                        
                            <p style="text-align: justify;width: 510px;margin-right: 10px;"><?php echo $mv['mision']; ?></p>
                        </div>
                        <div style="float: left;margin-bottom: 10px;">
                            <img src="../web/images/index/<?php echo $mv['img_m']; ?>" width="257" height="165" style="float: left;" />
                        </div>
                        <div style="width: 100%; height: 2px;"></div>
                        <div style="float: left;">
                            <h3 class="titleind">Visi&oacute;n</h3>
                            <p style="text-align: justify;width: 510px;margin-right: 10px;"><?php echo $mv['vision']; ?>.</p>
                        </div>
                        <div style="float: left;margin-bottom: 4%;">
                            <img src="../web/images/index/<?php echo $mv['img_v']; ?>" width="260" height="154" style="float: left;" />
                        </div>
                      
                    </div>
                </div>
                <div id="tab-2">
                    <div class="content">
                        <h2>Ampliar la capacidad resolutiva asistencial con la certificaci&oacute;n </h2>
                        <br />
                        <div style="text-align: justify;float: left;width: 545px;margin-right: 10px;">
                            <p>
                                <?php                                  
                                
                                    if(count($obejtivosemp)>0)
                                    {    $cn=0;
                                        foreach ($obejtivosemp as $i => $r) 
                                        {   
                                            $cn ++;
                                            echo $cn.'. '.$r['descripcion'].'<br />';
                                        }
                                    }
                                    
                                ?>
                               
                            </p>
                        </div>
                        <div style="float: left;">
                            <?php
                                $c=0;
                                    foreach ($obejtivosemp as $i => $img) 
                                    {  
                                        $c ++;
                                        if($c== 1)
                                        {
                                            
                                ?>
                                <img src="../web/images/index/<?php echo $img['img']; ?>" width="232" height="145" style="float: left;" />
                                <?php
                                
                                        }
                                    }
                            ?>
                        </div>
                        
                        
                    </div>
                </div>
                <div id="tab-3">
                    <div class="content">
                        <!-- <h3>Tab Two</h3> -->
                        <div style="text-align: justify;float: left;width: 545px;margin-right: 10px;">
                            <p>
                                <?php
                                    if(count($obejtivoscal)>0)
                                    {    $cnn=0;
                                        foreach ($obejtivoscal as $i => $rs) 
                                        {   
                                            $cnn ++;
                                            echo $cnn.'. '.$rs['descripcion'].'<br />';
                                        }
                                    }
                                ?>
                                <!--
                                1.	Impulsar   la calidad de la atenci&oacute;n del servicio  de obstetricia, tomando como referencia la Norma BPMG.<br />
                    			2.	Implementar los est&aacute;ndares de calidad en el  servicio de apoyo al tratamiento.<br />
                    			3.	Promover el desarrollo de las competencias del recurso humano.<br />
                    			4.	Medir la satisfacci&oacute;n de nuestros usuarios de acuerdo al servicio brindado.<br /><br />
                                -->
                            </p>
                        </div>
                        <div style="float: left;">
                            <?php
                                $c=0;
                                    foreach ($obejtivoscal as $i => $img) 
                                    {  
                                        $c ++;
                                        if($c== 1)
                                        {
                                            
                                ?>
                                <img src="../web/images/index/<?php echo $img['img']; ?>" width="232" height="145" style="float: left;" />
                                <?php
                                
                                        }
                                    }
                            ?>
                        </div>
                        
                        
                    </div>
                </div>
                <div id="tab-4">
                    <div class="content">
                        <div style="text-align: justify;float: left;width: 545px;margin-right: 10px;">
                            <p>
                                <?php
                                    if(count($obejtivoscap)>0)
                                    {    $cnn=0;
                                        foreach ($obejtivoscap as $i => $rs) 
                                        {   
                                            $cnn ++;
                                            echo $cnn.'. '.$rs['descripcion'].'<br />';
                                        }
                                    }
                                ?>
                                <!--
                                1.	Impulsar   la calidad de la atenci&oacute;n del servicio  de obstetricia, tomando como referencia la Norma BPMG.<br />
                    			2.	Implementar los est&aacute;ndares de calidad en el  servicio de apoyo al tratamiento.<br />
                    			3.	Promover el desarrollo de las competencias del recurso humano.<br />
                    			4.	Medir la satisfacci&oacute;n de nuestros usuarios de acuerdo al servicio brindado.<br /><br />
                                -->
                            </p>
                        </div>
                    </div>
                </div>
                <div id="tab-5">
                    <div class="content">
                        
                        <?php
                            if(count($valoresemp)>0)
                            {    
                                foreach ($valoresemp as $i => $res) 
                                {
                            ?>
                                <h3 class="titleind"><?php echo $res['valor']; ?></h3>
                                <p style="text-align: justify;"> 
                                    <?php echo $res['descripcion'].'<br />'; ?>
                                </p>
                            <?php                                    
                                   
                                }
                            }
                        ?>
                    </div>
                </div>
                <div id="tab-6">
                    <div class="content">
                        <div style="text-align: justify;float: left;width: 545px;margin-right: 10px;">
                            <p style="text-align: justify;"><?php echo $politica['descripcion']; ?> </p>
                        </div>
                        <div style="float: left;">
                            <img src="../web/images/index/<?php echo $politica['img']; ?>" width="232" height="145" style="float: left;" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    
</div>
