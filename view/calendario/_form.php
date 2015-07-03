<?php  
    include("../lib/helpers.php");
    include("../view/header_form.php");
?>

<form id="frm-calendario" >
    <input type="hidden" name="controller" value="calendario" />
    <input type="hidden" name="action" value="save" />
    <input type="hidden" name="idcalendario" value="<?php echo $obj->idcalendario; ?>" />
        
    <label for="descripcion" class="labels">Descripcion:</label>
    <input id="descripcion" name="descripcion" value="<?php echo $obj->descripcion; ?>" class="text ui-widget-content ui-corner-all" style=" width: 500px; text-align: left;" />
    <br/>
    
    <label for="estado" class="labels">Dia:</label>
    <?php
        echo "<select id='dia' class='text ui-widget-content ui-corner-all' style='width: 50px;'>";
        for($i=1;$i<=31;$i++)
        {
            echo "<option value='".$i."'>".$i."</option>";
        }
        echo "</select>";
    ?>
    
    <label class="labels">Mes</label>
    <select id="mes" name="mes" style="width: 90px" class='text ui-widget-content ui-corner-all'>
        <option value="1" <?=$obj->mes == 1 ? "selected='selected'" : "" ?> >Enero</option>
        <option value="2" <?=$obj->mes == 2 ? "selected='selected'" : "" ?> >Febrero</option>
        <option value="3" <?=$obj->mes == 3 ? "selected='selected'" : "" ?> >Marzo</option>
        <option value="4" <?=$obj->mes == 4 ? "selected='selected'" : "" ?> >Abril</option>
        <option value="5" <?=$obj->mes == 5 ? "selected='selected'" : "" ?> >Mayo</option>
        <option value="6" <?=$obj->mes == 6 ? "selected='selected'" : "" ?> >Junio</option>
        <option value="7" <?=$obj->mes == 7 ? "selected='selected'" : "" ?> >Julio</option>
        <option value="8" <?=$obj->mes == 8 ? "selected='selected'" : "" ?> >Agosto</option>
        <option value="9" <?=$obj->mes == 9 ? "selected='selected'" : "" ?> >Setiembre</option>
        <option value="10" <?=$obj->mes == 10 ? "selected='selected'" : "" ?> >Octubre</option>
        <option value="11" <?=$obj->mes == 11 ? "selected='selected'" : "" ?> >Noviembre</option>
        <option value="12" <?=$obj->mes == 12 ? "selected='selected'" : "" ?> >Diciembre</option>
    </select>
    
    <label for="anio" class="labels">Año:</label>
    <input id="anio" name="anio" value="<?php echo $obj->anio; ?>" class="text ui-widget-content ui-corner-all" style=" width: 50px; text-align: left;" />
    
    <br />
    <label for="estado" class="labels">Activo:</label>
    <div id="estados" style="display:inline">
        <?php                   
            if($obj->estado==1 || $obj->estado==0)
            {
                if($obj->estado==1){$rep=1;}
                else {$rep=0;}
            }
            else {$rep = 1;}                    
                activo('activo',$rep);
        ?>
    </div>     

</form>
