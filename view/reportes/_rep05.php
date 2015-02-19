<script type="text/javascript">
    $(document).ready(function () {
        $("#fechai,#fechaf").datepicker({dateFormat: 'dd/mm/yy'});
        $("#idperiodo").css("width", "auto");
        $("#idarticulo").focus();
        $( "#estados").buttonset();
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
                $.get('index.php','controller=reportes&action=data_rep05&tipo=consultar&'+str,function(r){

                    $("#load_resultado").empty().append(r);

                });
            }
        });
        
        $("#pdf").click(function ()
        {
            if (valid())
            {
                var str = $("#frm").serialize();
                window.open('index.php?controller=reportes&action=data_rep05&tipo=pdf&'+str, "Reporte");
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
    
    function TpFiltro(Op)
    {
        //alert(Op);
        if(Op==1)
        {
            $("#personal_name").attr('disabled',true)
            $("#idp").val('0')
        }
        else
            {
                $("#personal_name").attr('disabled',false)
                $("#idp").val('')
            }
    }
</script>
<div class="div_container">
    <h6 class="ui-widget-header ui-state-hover">Reporte: Capacitaciones por Personal</h6>
    <div style="padding: 20px;" class="ui-widget-content">
        <form name="frm" id="frm" action="" method="get">
            <label class="labels" for="idperiodo">Año: </label>
            <input type="text" name="anio" id="anio" value="<?php echo date('Y') ?>" class="ui-widget-content ui-corner-all text" style="width:100px; text-align:center" maxlength="4" onkeypress="return permite(event, 'num')"/>
            <br/>
            <label class="labels" for="personal">Personal: </label>        
            <input type="hidden" name="idp" id="idp" value="" />        
            <input type="text" name="personal_name" id="personal_name" value="" placeholder="Nombre del Personal" style="width:45%" class="text ui-widget-content ui-corner-all" /> 
             || Todos
            <div id="estados" style="display: inline;">
                <?php                                     
                    if($medfil==1 || $medfil==0)
                        {
                            if($medfil==1){$act="checked='checked' "; //$inac="";
                            }
                            else {$inac="checked='checked' ";}
                        }
                        else {$act = "checked='checked' ";}
                ?>
                <input type="radio" id="todos1" name="todos" value='1' onchange="TpFiltro(1)" <?php echo $act; ?> />
                <label for="todos1">SI</label>
                <input type="radio" id="todos0" name="todos" value='0' onchange="TpFiltro(0)"  <?php echo $inac; ?> />
                <label for="todos0">NO</label>
            </div> 
        </form>
        <div style="clear: both; padding: 5px; width: auto;text-align: center">        
            <a href="#" id="consultar" class="button">CONSULTAR</a>
            <a href="#" id="pdf" class="button">PDF</a>
        </div>
        <br />
        <div id="load_resultado" style="padding: 10px;"></div>
    </div>
    
</div>