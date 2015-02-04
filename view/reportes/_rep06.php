<script type="text/javascript">
    $(document).ready(function () {
        $( "#idtipo_documento" ).css({'width':'180px'});
        $("#anio").focus();
        $("#personal_name").autocomplete({
            minLength: 0,
            source: 'index.php?controller=personal&action=get&tipo=0',
            focus: function (event, ui)
            {
                return false;
            },
            select: function (event, ui)
            {
                $("#idp").val(ui.item.idpersonal);
                $("#personal_name").val(ui.item.nompersonal);
                $("#load_personal").focus();
                return false;
            }
        }).data("ui-autocomplete")._renderItem = function (ul, item)
        {
            return $("<li></li>")
                    .data("item.autocomplete", item)
                    .append("<a>"+item.dni+" - "+item.nompersonal+"</a>")
                    .appendTo(ul);
        };
        
        $("#consultar").click(function ()
        {
            if (valid())
            {
                var str = $("#frm").serialize();
                //window.open('index.php?controller=reportes&action=data_rep05&tipo=consultar&'+str, "Reporte");
                $.get('index.php','controller=reportes&action=data_rep06&tipo=consultar&'+str,function(r){
                    $("#load_resultado").empty().append(r);
                });
            }
        });
        
        $("#pdf").click(function ()
        {
            if (valid())
            {
                var str = $("#frm").serialize();
                window.open('index.php?controller=reportes&action=data_rep06&tipo=pdf&'+str, "Reporte");
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
<div class="div_container">
    <h6 class="ui-widget-header ui-state-hover">Reporte: Documentos por Personal</h6>
    <div style="padding: 20px;" class="ui-widget-content">
        <form name="frm" id="frm" action="" method="get">
            <label class="labels" for="idperiodo">Año: </label>
            <input type="text" name="anio" id="anio" value="<?php echo date('Y') ?>" class="ui-widget-content ui-corner-all text" style="width:100px; text-align:center" maxlength="4" onkeypress="return permite(event, 'num')"/>
            <br/>
            <label class="labels" for="idperiodo">Tipo Doc.: </label>
            <?php echo $tipodoc; ?>
            <br/>
            <label class="labels" for="personal">Personal: </label>        
            <input type="hidden" name="idp" id="idp" value="" />        
            <input type="text" name="personal_name" id="personal_name" value="" placeholder="Nombre del Personal" style="width:65%" class="text ui-widget-content ui-corner-all" />
            
            
        </form>
        <div style="clear: both; padding: 5px; width: auto;text-align: center">        
            <a href="#" id="consultar" class="button">CONSULTAR</a>
            <a href="#" id="pdf" class="button">PDF</a>
        </div>
        <br />
        <div id="load_resultado" style="padding: 10px;"></div>
    </div>
    
</div>