<script type="text/javascript">
$(document).ready(function(){
    $("#fechai,#fechaf").datepicker({ dateFormat:'dd/mm/yy' });        
    $("#idperiodo").css("width","auto");
    $("#idarticulo").focus();
    $("#personal_name").autocomplete({
        minLength: 0,
        source: 'index.php?controller=personal&action=get&tipo=0',
        focus: function( event, ui ) 
        {
            return false;
        },
        select: function( event, ui ) 
        {
            $("#idp").val(ui.item.idpersonal);              
            $("#personal_name" ).val( ui.item.nompersonal );
            $("#load_personal").focus();
            return false;
        }
     }).data( "ui-autocomplete" )._renderItem = function( ul, item ) 
     {
        return $( "<li></li>" )
            .data( "item.autocomplete", item )
            .append( "<a>"+ item.dni +" - " + item.nompersonal + "</a>" )
            .appendTo(ul);
      };
    $("#gen").click(function()
    {
        if(valid())
            {
                var str = $("#frm").serialize();
                window.open('index.php?controller=reportes&action=data_rep02&tipo=excel&'+str,"Reporte");
            }
    });
    $("#pdf").click(function()
    {
        if(valid())
            {
                var str = $("#frm").serialize();
                window.open('index.php?controller=reportes&action=data_rep02&tipo=pdf&'+str,"Reporte");
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
<h6 class="ui-widget-header ui-state-hover">Reporte Resultados de Evaluacion Anual</h6>
<div style="padding: 20px;" class="ui-widget-content">
    <form name="frm" id="frm" action="" method="get">
        <label class="labels" for="idperiodo">Año: </label>
        <input type="text" name="anio" id="anio" value="<?php echo date('Y') ?>" class="ui-widget-content ui-corner-all text" style="width:100px; text-align:center" maxlength="4" onkeypress="return permite(event,'num')"/>
        <br/>
        <label class="labels" for="personal">Personal: </label>        
        <input type="hidden" name="idp" id="idp" value="" />        
        <input type="text" name="personal_name" id="personal_name" value="" placeholder="Nombre del Personal" style="width:65%" class="text ui-widget-content ui-corner-all" />        
    </form>
    <div style="clear: both; padding: 5px; width: auto;text-align: center">        
        <a href="#" id="gen" class="button">EXCEL</a>
        <a href="#" id="pdf" class="button">PDF</a>
    </div>
</div>
<div id="wcont" style="padding: 10px;"></div>
</div>