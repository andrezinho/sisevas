<script type="text/javascript">
    $(document).ready(function () {
        $("#anioc").focus();
        $("#anioc1, #anioc2").val('2015');        
        $("#idperiodo1, #idperiodo2").css({'width':'180px'});
        $("#idcompetencia1, #idcompetencia2").css({'width':'375px'});
        $("#idaspecto").css({'width':'450px'});
        $("#idcompetencia2").change(function(){loadAspectos($(this).val());});
        var anio=<?=date("Y");?>;
        var tp=1; var tipo=0;
        loadPeriodo(anio,tp,tipo);
    });
    
    function loadPeriodo(anio,tp,tipo)
    {
        var tpp=2;
        $.get('index.php','anio='+anio+'&controller=periodo&action=getPeriodos',function(r){
            var options = "<option value='0'>.:: Todos ::.</option>";
            $.each(r,function(i,j){
                    options += "<option value='"+j['id']+"'>"+j['descripcion']+"</option>";
            });
            
            if(tipo==0)
            {
               $("#idperiodo"+tp).empty().append(options);
               $("#idperiodo"+tpp).empty().append(options); 
            }else
                {
                    $("#idperiodo"+tp).empty().append(options);
                }
            
        },'json');
        //$(".periodos").empty();
    }
    
    function loadAspectos(idc)
    {
        $.get('index.php','idc='+idc+'&controller=aspectos&action=getAspectos',function(r){
            var options = "<option value=''>Seleccione....</option>";
            $.each(r,function(i,j){
                    options += "<option value='"+j['id']+"'>"+j['descripcion']+"</option>";
            });						
            $("#idaspecto").empty().append(options);
        },'json');
    }
        
    function consultar(tp)
    {
        var anioc = $("#anioc"+tp).val();
        var idper= $("#idperiodo"+tp).val();
        var idcom= $("#idcompetencia"+tp).val();
        var idasp= $("#idaspecto").val();
        if (valid(tp))
        {
            $.get('index.php', 'controller=reportes&action=data_parametros&tipo=consultar&idper='+idper+'&tp='+tp+'&idcomp='+idcom+'&idasp='+idasp+'&anio='+anioc, function (r) {
                $("#load_resultado"+tp).empty().append(r);
            });
        }
    }

    function pdf(tp)
    {
        var anioc = $("#anioc"+tp).val();
        var idper= $("#idperiodo"+tp).val();
        var idcom= $("#idcompetencia"+tp).val();
        var idasp= $("#idaspecto").val();
        if (valid(tp))
        {
            var anioc = $("#anioc"+tp).val();
            window.open('index.php?controller=reportes&action=data_parametros&tipo=pdf&idper='+idper+'&tp='+tp+'&idcomp='+idcom+'&idasp='+idasp+'&anio='+anioc, "Reporte");
        }
    }

    function valid(tp)
    {
        if(tp==1)
        {
            var bval = true;
            bval = bval && $("#anioc"+tp).required();
            bval = bval && $("#idperiodo"+tp).required();
            bval = bval && $("#idcompetencia"+tp).required();
        }else
            {
                var bval = true;
                bval = bval && $("#anioc"+tp).required();
                bval = bval && $("#idperiodo"+tp).required();
                bval = bval && $("#idcompetencia"+tp).required();
                bval = bval && $("#idaspecto").required();
            }
        
        return bval;
    }
</script>
<style type="text/css">
    .ac-container{
        width: 850px;
        margin: 10px auto 30px auto;
        text-align: left;
    }
    .ac-container label{
        font-family: 'BebasNeueRegular', 'Arial Narrow', Arial, sans-serif;
        padding: 5px 20px;
        position: relative;
        z-index: 20;
        display: block;
        height: 30px;
        cursor: pointer;
        color: #777;
        text-shadow: 1px 1px 1px rgba(255,255,255,0.8);
        line-height: 33px;
        font-size: 15px;
        background: #ffffff;
        background: -moz-linear-gradient(top, #ffffff 1%, #eaeaea 100%);
        background: -webkit-gradient(linear, left top, left bottom, color-stop(1%,#ffffff), color-stop(100%,#eaeaea));
        background: -webkit-linear-gradient(top, #ffffff 1%,#eaeaea 100%);
        background: -o-linear-gradient(top, #ffffff 1%,#eaeaea 100%);
        background: -ms-linear-gradient(top, #ffffff 1%,#eaeaea 100%);
        background: linear-gradient(top, #ffffff 1%,#eaeaea 100%);
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#eaeaea',GradientType=0 );
        box-shadow: 
            0px 0px 0px 1px rgba(155,155,155,0.3), 
            1px 0px 0px 0px rgba(255,255,255,0.9) inset, 
            0px 2px 2px rgba(0,0,0,0.1);
    }
    .ac-container label:hover{
        background: #fff;
    }
    .ac-container span{
        font-family: 'BebasNeueRegular', 'Arial Narrow', Arial, sans-serif;
        font-weight: bold;
        padding: 5px 20px;
        position: relative;
        height: 20px;
        color: #777;
        text-shadow: 1px 1px 1px rgba(255,255,255,0.8);
        font-size: 15px;
        box-shadow: 
            0px 0px 0px 1px rgba(155,155,155,0.3), 
            1px 0px 0px 0px rgba(255,255,255,0.9) inset, 
            0px 2px 2px rgba(0,0,0,0.1);
    }
    .ac-container input:checked+label,
    .ac-container input:checked+label:hover{
        background: #c6e1ec;
        color: #3d7489;
        text-shadow: 0px 1px 1px rgba(255,255,255, 0.6);
        box-shadow: 
            0px 0px 0px 1px rgba(155,155,155,0.3), 
            0px 2px 2px rgba(0,0,0,0.1);
    }
    .ac-container label:hover:after,
    .ac-container input:checked+label:hover:after{
        content: '';
        position: absolute;
        width: 24px;
        height: 24px;
        right: 13px;
        top: 7px;
        background: transparent url(../web/images/arrow_down.png) no-repeat center center;	
    }
    .ac-container input:checked+label:hover:after{
        background-image: url(../web/images/arrow_up.png);
    }
    .ac-container input{
        display: none;
    }
    .ac-container article{
        background: rgba(255, 255, 255, 0.5);
        margin-top: -1px;
        overflow: hidden;
        height: 0px;
        position: relative;
        z-index: 10;
        -webkit-transition: height 0.3s ease-in-out, box-shadow 0.6s linear;
        -moz-transition: height 0.3s ease-in-out, box-shadow 0.6s linear;
        -o-transition: height 0.3s ease-in-out, box-shadow 0.6s linear;
        -ms-transition: height 0.3s ease-in-out, box-shadow 0.6s linear;
        transition: height 0.3s ease-in-out, box-shadow 0.6s linear;
    }
    .ac-container article p{
        font-style: italic;
        color: #777;
        line-height: 23px;
        font-size: 14px;
        padding: 20px;
        text-shadow: 1px 1px 1px rgba(255,255,255,0.8);
    }
    .ac-container input:checked ~ article{
        -webkit-transition: height 0.5s ease-in-out, box-shadow 0.1s linear;
        -moz-transition: height 0.5s ease-in-out, box-shadow 0.1s linear;
        -o-transition: height 0.5s ease-in-out, box-shadow 0.1s linear;
        -ms-transition: height 0.5s ease-in-out, box-shadow 0.1s linear;
        transition: height 0.5s ease-in-out, box-shadow 0.1s linear;
        box-shadow: 0px 0px 0px 1px rgba(155,155,155,0.3);
    }
    .ac-container input:checked ~ article.ac-small{
        height: 140px;
    }
    .ac-container input:checked ~ article.ac-medium{
        height: 180px;
    }
    .ac-container input:checked ~ article.ac-large{
        height: 370px;
        overflow: auto;
    }
</style>
<div class="div_container">
    <h6 class="ui-widget-header ui-state-hover">Reporte: Evalucion</h6>
    <div style="height: 510px;" class="ui-widget-content">
        <form name="frm" id="frm" action="" method="get">

            <section class="ac-container">
                <div>
                    <input id="ac-1" name="accordion-1" type="radio" checked />
                    <label for="ac-1">Competencias</label>
                    <article class="ac-large">
                        <br/><br/>
                        <span>Seleccione el A&ntilde;o:</span>    
                        <?php
                            $anio=date("Y");
                            echo "<select id='anioc1' class='text ui-widget-content ui-corner-all' style='width: 90px;' onClick='loadPeriodo($(this).val(),1,1)'>
                            <option value='0'>".'.: Todos :.'."</option>";
                            for ($i = 2010; $i <=$anio; $i++) {
                                echo "<option value='".$i."'>".$i."</option>";
                            }
                            echo "</select>";
                        ?>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Periodo:</span>    
                        <select id="idperiodo1" class="periodos text ui-widget-content ui-corner-all" style="width: 90px;">
                        </select>
                        <br/>
                        <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Competencia:</span>
                        <?php echo $competencias1; ?>
                        <br/>
                        <div style="clear: both; padding: 5px; width: auto;text-align: center">        
                            <a onclick="consultar(1);" id="consultar" class="button">CONSULTAR</a>
                            <a onclick="pdf(1);" id="pdf" class="button">PDF</a>
                        </div>
                        <br />
                        <div id="load_resultado1" style="padding: 10px;"></div>

                    </article>
                </div>
                <div>
                    <input id="ac-2" name="accordion-1" type="radio" />
                    <label for="ac-2">Aspectos</label>
                    <article class="ac-large">
                        <br/><br/>
                        <span>Seleccione el A&ntilde;o:</span>    
                        <?php
                        $anio=date("Y");
                        echo "<select id='anioc2' class='text ui-widget-content ui-corner-all' style='width: 90px;' onClick='loadPeriodo($(this).val(),2,1)'>
                            <option value='0'>".'.: Todos :.'."</option>";
                        for ($i = 2010; $i <=$anio; $i++) {
                            echo "<option value='".$i."'>".$i."</option>";
                        }
                        echo "</select>";
                        ?>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Periodo:</span>    
                        <select id="idperiodo2" class="periodos text ui-widget-content ui-corner-all" style="width: 90px;">
                        </select>
                        <br/>
                        <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Competencia:</span>
                        <?php echo $competencias2; ?>
                        
                        <br/>
                        <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Aspectos:</span>
                        <select name="idaspecto" id="idaspecto" class="ui-widget-content text ui-corner-all">
                                <option value="">...</select>
                        </select>
                        <br/>					
                        <div style="clear: both; padding: 5px; width: auto;text-align: center">        
                            <a onclick="consultar(2);" id="consultar" class="button">CONSULTAR</a>
                            <a onclick="pdf(2);" id="pdf" class="button">PDF</a>
                        </div>
                        <br />
                        <div id="load_resultado2" style="padding: 10px;"></div>

                    </article>
                </div>
                

            </section>
        </form>

    </div>

</div>