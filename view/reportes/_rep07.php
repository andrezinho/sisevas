<script type="text/javascript">
    $(document).ready(function () {
        
        $("#anio").focus();
        
        $("#consultar").click(function ()
        {
            if (valid())
            {
                //alert('');
                var str = $("#frm").serialize();
                //window.open('index.php?controller=reportes&action=data_rep07&tipo=consultar&'+str, "Reporte");
                $.get('index.php','controller=reportes&action=data_rep07&tipo=consultar&'+str,function(r){
                    $("#load_resultado").empty().append(r);
                });
            }
        });
        
        $("#pdf").click(function ()
        {
            if (valid())
            {
                var str = $("#frm").serialize();
                window.open('index.php?controller=reportes&action=data_rep07&tipo=pdf&'+str, "Reporte");
            }
        });      
        
    });
    
    function valid()
    {
        var bval = true;
        bval = bval && $("#idp").required();
        bval = bval && $("#anio").required();
        return bval;
    }
</script>
<style type="text/css">
.ac-container{
	width: 800px;
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
.ac-container input:checked + label,
.ac-container input:checked + label:hover{
	background: #c6e1ec;
	color: #3d7489;
	text-shadow: 0px 1px 1px rgba(255,255,255, 0.6);
	box-shadow: 
		0px 0px 0px 1px rgba(155,155,155,0.3), 
		0px 2px 2px rgba(0,0,0,0.1);
}
.ac-container label:hover:after,
.ac-container input:checked + label:hover:after{
	content: '';
	position: absolute;
	width: 24px;
	height: 24px;
	right: 13px;
	top: 7px;
	background: transparent url(../web/images/arrow_down.png) no-repeat center center;	
}
.ac-container input:checked + label:hover:after{
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
	min-height: 230px;
    overflow: scroll;
}
</style>
<div class="div_container">
    <h6 class="ui-widget-header ui-state-hover">Reporte: Documentos por Personal</h6>
    <div style="padding: 20px;" class="ui-widget-content">
        <form name="frm" id="frm" action="" method="get">
            
            <section class="ac-container">
                <div>
					<input id="ac-1" name="accordion-1" type="radio" checked />
					<label for="ac-1">Objetivos de Capaciotacion / Tipo Alcance</label>
					<article class="ac-large">
						
                            <input type="hidden" name="tipo" name="tipo" value="1" />
                            <div style="clear: both; padding: 5px; width: auto;text-align: center">        
                                <a href="#" id="consultar" class="button">CONSULTAR</a>
                                <a href="#" id="pdf" class="button">PDF</a>
                            </div>
                            <br />
                            <div id="load_resultado" style="padding: 10px;"></div>
                        
					</article>
				</div>
				<div>
					<input id="ac-2" name="accordion-1" type="radio" />
					<label for="ac-2">Eje de Capacitacion / Tipo Alcance</label>
					<article class="ac-large">
						<p>Like you, I used to think the world was this great place where everybody lived by the same standards I did, then some kid with a nail showed me I was living in his world, a world where chaos rules not order, a world where righteousness is not rewarded. That's Cesar's world, and if you're not willing to play by his rules, then you're gonna have to pay the price. </p>
					</article>
				</div>
                <div>
					<input id="ac-3" name="accordion-1" type="radio" />
					<label for="ac-3">Personal / Tipo Alcance</label>
					<article class="ac-large">
						<p>You think water moves fast? You should see ice. It moves like it has a mind. Like it knows it killed the world once and got a taste for murder. After the avalanche, it took us a week to climb out. Now, I don't know exactly when we turned on each other, but I know that seven of us survived the slide... and only five made it out. Now we took an oath, that I'm breaking now. We said we'd say it was the snow that killed the other two, but it wasn't. Nature is lethal but it doesn't hold a candle to man. </p>
					</article>
				</div>
				<div>
					<input id="ac-4" name="accordion-1" type="radio" />
					<label for="ac-4">Objetivos de la empresa / Tipo Alcance</label>
					<article class="ac-large">
						<p>You see? It's curious. Ted did figure it out - time travel. And when we get back, we gonna tell everyone. How it's possible, how it's done, what the dangers are. But then why fifty years in the future when the spacecraft encounters a black hole does the computer call it an 'unknown entry event'? Why don't they know? If they don't know, that means we never told anyone. And if we never told anyone it means we never made it back. Hence we die down here. Just as a matter of deductive logic. </p>
					</article>
				</div>
            </section>
        </form>
        
    </div>
    
</div>