<?php  include("../lib/helpers.php"); 
       include("../view/header_form.php");
       
?>
<script type="text/javascript">
$(document).ready(function(){
    $("#fechai,#fechaf").datepicker({ dateFormat:'dd/mm/yy' });        
    $("#idperiodo").css("width","auto");
    $("#idarticulo").focus();

    $("#btn-close").click(function()
    {
        $.post('index.php','controller=periodo&action=closeok',function(data){
            alert(data);
        })
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
<h6 class="ui-widget-header ui-state-hover">Cerrar Periodo</h6>
<div style="padding: 20px;" class="ui-widget-content">
    <form name="frm" id="frm" action="" method="get">
        <label class="labels" for="descripcion">Descripcion: </label>
        <input type="text" name="descripcion" id="descripcion" value="<?php echo $obj->descripcion; ?>" style="width:250px" class="text ui-widget-content ui-corner-all" disabled="disabled" />
        <br/>
        <label class="labels" for="fecha_apertura">Fecha Apertura: </label>
        <input type="text" name="fecha_apertura" id="fecha_apertura" value="<?php echo ffecha($obj->fecha_apertura); ?>" style="width:100px" class="text ui-widget-content ui-corner-all" disabled="disabled" />
        <br/>
        <label class="labels" for="fecha_cierre">Fecha Cierre: </label>
        <input type="text" name="fecha_cierre" id="fecha_cierre" value="<?php echo ffecha($obj->fecha_cierre) ?>" style="width:100px;" class="text ui-widget-content ui-corner-all" disabled="disabled" />
        <br/>
        <label class="labels" for="personal">Año: </label>
        <input type="text" name="anio" id="anio" value="<?php echo $obj->anio ?>" style="width:100px" class="text ui-widget-content ui-corner-all" disabled="disabled" />
        <br/>
        <br/>
        <div style="padding-left:103px">
        <a href="#" id="btn-close" class="button">Cerrar Periodo</a>
        </div>
    </form>
</div>
<div id="wcont" style="padding: 10px;"></div>
</div>