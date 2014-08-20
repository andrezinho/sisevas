<div class="div_container">
<!-- <h6 class="ui-widget-header ui-state-hover">&nbsp;</h6>-->
	
    <div class="contain-left">
        <!--<p class="titleind"><strong><a href="">MISI&Oacute;N</a></strong></p>
        <p class="titleind"><strong><a href="">VISI&Oacute;N</strong></a></p>
        <p class="titleind"><strong><a href="">ORGANIGRAMA</strong></a></p>-->
        <br /><br />
        <img border="0" src="images/Leyendo.gif" />
    </div>
    <div class="contain-der">
               
        <div id="tabsindex" class="tabsindex">
            <ul>
                <li><a href="#tab-1">MISI&Oacute;N Y VISI&Oacute;N</a></li>
                <li><a href="#tab-2">OBJETIVOS DE LA EMPRESA</a></li>
                <li><a href="#tab-3">OBJETIVOS DE LA CALIDAD</a></li>
                <li><a href="#tab-4">VALORES</a></li>
                <li><a href="#tab-5">POL&IacuteTICA DE CALIDAD</a></li>
            </ul>
            <div class="tabscontent">
                <div id="tab-1">
                    <div class="content">
                        <div style="float: left;">
                            <h3 class="titleind">Misi&oacute;n</h3>                        
                            <p style="text-align: justify;width: 400px;margin-right: 10px;"><?php echo $mv['mision']; ?></p>
                        </div>
                        <div style="float: left;margin-bottom: 10px;">
                            <img src="../web/images/index/<?php echo $mv['img_m']; ?>" width="257" height="165" style="float: left;" />
                        </div>
                        <div style="width: 100%; height: 2px;"></div>
                        <div style="float: left;">
            	        	<h3 class="titleind">Visi&oacute;n</h3>
                            <p style="text-align: justify;width: 400px;margin-right: 10px;"><?php echo $mv['vision']; ?>.</p>
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
                        <div style="text-align: justify;float: left;width: 420px;margin-right: 10px;">
                            <p>
                                <?php
                                    if(count($obejtivosemp)>0)
                                    {    $cn=0;
                                        foreach ($obejtivosemp as $i => $r) 
                                        {   
                                            $cn ++;
                                            echo $cn.'.- '.$r['descripcion'].'<br />';
                                        }
                                    }
                                ?>
                                <!--
                                1. Impulsar acciones de prevenci&oacute;n y promoci&oacute;n en base a paquetes de atenci&oacute;n con &eacute;nfasis en la atenci&oacute;n de la mujer (COMUNICACI&Oacute;N).<br />
                    			2. Fortalecer  la calidad de la atenci&oacute;n de los consultorios (IDENTIDAD).<br />
                    			3. Garantizar la calidad de los sistemas de soporte. (IMAGEN).<br />
                    			4. Fortalecer  el programa de inversiones de la empresa (IMAGEN).<br />
                                5. Desarrollar  la red privada en salud (IMAGEN).<br />
                                6. Desarrollo de una pol&iacute;tica de marketing institucional (COMUNICACI&Oacute;N).<br />
                                7. Desarrollo de un sistema de captaci&oacute;n de clientes con reglas claras del mercado (COMUNICACI&Oacute;N).<br />
                                8. Garantizar la calidad de la hospitalizaci&oacute;n y emergencia (IDENTIDAD).<br />
                                9. Promover el desarrollo de las competencias del RRHH(IDENTIDAD).<br /><br />*/
                                -->
                            </p>
                        </div>
                        <div style="float: left;">
                            <img src="../web/images/OBJETIBOSC.png" width="232" height="145" style="float: left;" />
                        </div>
                        
                        
                    </div>
                </div>
                <div id="tab-3">
                    <div class="content">
                        <!-- <h3>Tab Two</h3> -->
                        <div style="text-align: justify;float: left;width: 420px;margin-right: 10px;">
                            <p>
                                <?php
                                    if(count($obejtivoscal)>0)
                                    {    $cnn=0;
                                        foreach ($obejtivoscal as $i => $rs) 
                                        {   
                                            $cnn ++;
                                            echo $cnn.'.- '.$rs['descripcion'].'<br />';
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
                            <img src="../web/images/OBJETIVOSCA.png" width="232" height="145" style="float: left;" />
                        </div>
                        
                        
                    </div>
                </div>
                <div id="tab-4">
                    <div class="content">
                        <!--
                        <h3 class="titleind">INNOVACI&oacute;N</h3>
                        <p style="text-align: justify;"> 
                            Hacer las cosas de manera diferente, aplicaci&oacute;n de nuevas ideas, conceptos, productos, servicios y pr&aacute;cticas, con la intenci&oacute;n de ser &uacute;tiles. Buscamos  la mejora continua de nuestros procesos y servicios y no nos conformamos con proponer ideas sino que las llevamos a la pr&aacute;ctica como parte de nuestro reto diario para el mejoramiento contin&uacute;o.
                        </p>
                        <div style="float: left;">
                        <h3 class="titleind">CALIDEZ</h3>
                            <p style="text-align: justify;width: 480px;"> 
                                Nos esforzamos por conocer y comprender las necesidades de nuestros clientes, excediendo sus demandas y expectativas. Brindamos los servicios acompa&ntilde;ados de amabilidad y cortes&iacute;acute;a.
                            </p>
                            
                            <h3 class="titleind">CONFIANZA</h3>
                            <p style="text-align: justify;width: 480px;"> 
                                Actuamos de acuerdo a los principios, normas y pol&iacute;ticas de la empresa. Realizamos nuestras labores aplicando protocolos institucionalizados por la empresa, con la finalidad de satisfacer a cada uno de nuestros clientes
                            </p>
                            <h3 class="titleind">TRABAJO EN EQUIPO</h3>
                            <p style="text-align: justify;width: 480px;"> 
                                Cooperamos dentro y entre &aacute;reas y unidades productivas porque estamos comprometidos y alineados con el logro de nuestros objetivos corporativos; priorizamos siempre los intereses de la empresa por sobre los intereses de cualquier &aacute;rea o persona.
                            </p>
                        </div>
                        <div style="float: left;">
                            <img src="../web/images/VALORESIN.png" style="float: left;" />
                        </div>
                        <br />
                        <div style="float: left;">
                            <h3 class="titleind">COMPROMISO</h3>
                            <p style="text-align: justify;"> 
                                Buscamos siempre la excelencia mediante la aplicaci&oacute;n de la mejora continua, mejoramos nuestras competencias personales y profesionales, cumplimos y excedemos los est&aacute;ndares de las normas de  calidad. Participamos en todas la etapas del proceso de calidad.
                            </p>
                        </div>
                        -->
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
                <div id="tab-5">
                    <div class="content">
                        <div style="text-align: justify;float: left;width: 420px;margin-right: 10px;">
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
