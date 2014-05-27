<script type="text/javascript">
$(document).ready(function(){
    $("#fechai,#fechaf").datepicker({ dateFormat:'dd/mm/yy' });        
    $("#idperiodo").css("width","auto");
    $("#idarticulo").focus();
    $("#gen").click(function(){      
        if(valid())
            {
                var str = $("#frm").serialize();
                $.get('index.php','controller=evaluacion&action=reporte_detallado&'+str,function(data){
                    $("#wcont").empty().append(data);
                });
            }
    });
    $("#pdf").click(function()
    {
        if(valid())
            {
                var str = $("#frm").serialize();
                window.open('index.php?controller=reportes&action=pdf_egresos&'+str,"Reporte");
            }
    });
});
function valid()
{
    var bval = true;            
        bval = bval && $("#fechai").required();
        bval = bval && $("#fechaf").required();
    return bval;
}
</script>
<div class="div_container">
<h6 class="ui-widget-header ui-state-hover">Reporte Resultados de Evaluacion por Periodo</h6>
<div style="padding: 20px; background: #EBECEC">
    <form name="frm" id="frm" action="" method="get">
        <label class="labels" for="idperiodo">Periodo: </label>
        <?php echo $periodo; ?>        
    </form>
    <div style="clear: both; padding: 5px; width: auto;text-align: center">
        <a href="index.php" class="button">CERRAR</a>
        <a href="#" id="gen" class="button">EXCEL</a>
        <a href="#" id="pdf" class="button">PDF</a>
    </div>
</div>
<div id="wcont" style="padding: 10px;"></div>
</div>