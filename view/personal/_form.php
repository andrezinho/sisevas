<?php  include("../lib/helpers.php"); 
       include("../view/header_form.php");
?>
<style type="text/css">
.subir_file{
    margin-left: 20%;
    /*margin-top: 2%;*/
}

</style>

<div style="padding:10px 20px">
<form id="frm" >

    <input type="hidden" name="controller" value="Personal" />
    <input type="hidden" name="action" value="save" />
    <input type="hidden" id="idpersonal" name="idpersonal" value="<?php echo $obj->idpersonal; ?>" />
    <div id="tabs">
        <ul style="background:#DADADA !important; border:0 !important">
            <li><a href="#tabs-1">Información Personal</a></li>
            <li><a href="#tabs-2">Información Laboral</a></li>
            <li><a href="#tabs-3">Otros</a></li>
            <li><a href="#tabs-4">File</a></li>
            <li><a href="#tabs-5">Salud Ocupacional</a></li>
        </ul>
        <div id="tabs-1">

            <label for="docidentidad" class="labels">Doc. Identidad:</label>        
            <?php echo $documentoidentidad; ?>
                    
            <label for="dni" class="labels">DNI:</label>
            <input id="dni" name="dni" onkeypress="return permite(event,'num');" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->dni; ?>"  />
            <br />

            <label for="nombres" class="labels">Nombres:</label>
            <input type="text" id="nombres" maxlength="100" name="nombres" onkeypress="return permite(event,'car');" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->nombres; ?>" />
            
            <label for="apellidos" class="labels">Apellidos:</label>
            <input type="text" id="apellidos" name="apellidos" onkeypress="return permite(event,'car');" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->apellidos; ?>" />
            <br/> 

            <label for="telefono" class="labels">Telefono:</label>
            <input type="text" id="telefono" name="telefono" onkeypress="return permite(event,'num');" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->telefono; ?>" />
            
            <label for="fechanaci" class="labels">Fecha Nac:</label>
            <input type="text" id="fechanaci" maxlength="10" name="fechanaci" class="text ui-widget-content ui-corner-all" style=" width: 100px; text-align: left;" value="<?php if($obj->fechanaci=='') echo date('d/m/Y'); else echo fdate($obj->fechanaci,'ES'); ?>" />
            <br/>

            <label for="direccion" class="labels">Dirección:</label>
            <input id="direccion" name="direccion" onkeypress="return permite(event,'num_car');" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->direccion; ?>" />
            
            <label for="estcivil" class="labels">Estado civil:</label>        
            <?php echo $EstadoCivil; ?>
            <br/>

            <label for="email" class="labels">Email:</label>  
            <input id="email" name="email" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->mail; ?>" />
            
            <label for="sexo" class="labels">Sexo:</label>        
            <select id="sexo" name="sexo" class="ui-widget-content ui-corner-all">
                <?php $var="";
                    if($obj->sexo=='M')
                    {$var="selected";}               
                ?>
                <option <?php echo $var; ?> value="M">Masculino</option>

                <?php $var="";
                    if($obj->sexo=='F')
                    {$var="selected";}               
                ?>
                <option <?php echo $var; ?> value="F">Femenino</option>
            </select>

        </div>
        <div id="tabs-2">

            <label for="tipopersonal" class="labels">Perfil Ocupac.:</label>        
            <?php echo $tipopersonal; ?>

            <label for="Especialidad" class="labels">Especialidad:</label>
            <?php echo $especialidad; ?>
            <br/>

            <label for="grado" class="labels">Grado Instruccion:</label>
            <?php echo $grado; ?>

            <label for="idcargo" class="labels">Cargo:</label>
            <?php echo $idcargo; ?>
            <br/>

            <label for="estcivil" class="labels">Unidad Operativa:</label>        
            <?php echo $consultorio; ?>

            <label for="perfil" class="labels">Perfil de Eva.:</label>
            <?php echo $Perfil; ?>   
            <br/>

            <label for="fechaing" class="labels">Fecha Ingreso:</label>
            <input type="text" id="fechaing" maxlength="10" name="fechaing" class="text ui-widget-content ui-corner-all" style=" width: 100px; text-align: left;" value="<?php if($obj->fechareg=='') echo date('d/m/Y'); else echo fdate($obj->fechareg,'ES'); ?>" />
            
            <label for="fechaing" class="labels">Asumir Cargo:</label>
            <input type="text" id="asumircargo" maxlength="10" name="asumircargo" class="text ui-widget-content ui-corner-all" style=" width: 100px; text-align: left;" value="<?php if($obj->asumircargo=='') echo date('d/m/Y'); else echo fdate($obj->asumircargo,'ES'); ?>" />
            <br/>

            <label for="user" class="labels">Usuario:</label>
            <input id="usuario" name="usuario" value="<?php echo $obj->usuario; ?>" onkeypress="return permite(event,'num_car');" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" />
            
            <label for="clae" class="labels">Clave:</label>            
            <input type="password" id="clave" name="clave" value="<?php echo $obj->clave; ?>" onkeypress="return permite(event,'num_car');" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" />
            <br/>
            
            <label for="clae" class="labels">Contrato:</label>
            <div class="subir_file">
                <input type="hidden" name="contrato" id="contrato" value="<?php echo $obj->contrato; ?>" />
                    <?php
                        if($obj->file!="")
                            $d = "inline";
                        else
                            $d = "none";
                    ?>
                <div id="queue"></div>
                <input id="file_contrato" name="file_contrato" type="file" multiple="true">    
                <a target="_blank" href="files/contratos/<?php echo $obj->contrato ?>" style="display:<?php echo $d; ?>;cursor:pointer; font-size: 11px;" id="VerC"><img src="images/pdf.png" />Abrir Archivo</a>
            </div>
        </div>

        <div id="tabs-3">

            <label for="ruc" class="labels">RUC:</label>
            <input id="ruc" name="ruc" onkeypress="return permite(event,'num');" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->ruc; ?>"  />
            
            <label for="codafp" class="labels">Cod. AFP:</label>
            <input id="codafp" name="codafp" onkeypress="return permite(event,'num_car');" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->codafp; ?>"  />
            <br/>

            <label for="ruc" class="labels">Cod. Essalud:</label>
            <input id="codessalud" name="codessalud" onkeypress="return permite(event,'num_car');" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->codessalud; ?>"  />
            <br/>
            
            <label for="fechanaci" class="labeless">Cumpleaños Espo.:</label>
            <input type="text" id="cumpleesposa" maxlength="10" name="cumpleesposa" class="text ui-widget-content ui-corner-all" style=" width: 100px; text-align: left;" value="<?php if($obj->cumpleesposa=='') echo date('d/m/Y'); else echo fdate($obj->cumpleesposa,'ES'); ?>" />
            
            <label for="fechanaci" class="labeless">Cumpleaños Hijo.:</label>
            <input type="text" id="cumplehijo" maxlength="10" name="cumplehijo" class="text ui-widget-content ui-corner-all" style=" width: 100px; text-align: left;" value="<?php if($obj->cumplehijo=='') echo date('d/m/Y'); else echo fdate($obj->cumplehijo,'ES'); ?>" />
            <br/>
        </div>
        <div id="tabs-4">            
            <input type="hidden" name="archivo" id="archivo" value="<?php echo $obj->file; ?>" />
                <?php
                    if($obj->file!="")
                        $d = "inline";
                    else
                        $d = "none";
                ?>
            <div id="queue"></div>
            <input id="file_upload" name="file_upload" type="file" multiple="true" />    
                <a target="_blank" href="files/<?php echo $obj->file ?>" style="display:<?php echo $d; ?>;cursor:pointer; font-size: 11px;" id="VerImagennn"><img src="images/pdf.png" />Abrir Archivo</a>
        </div>
        <div id="tabs-5">            
            <input type="hidden" name="archivo_hc" id="archivo_hc" value="<?php echo $obj->file_hc; ?>" />
                <?php
                    if($obj->file_hc!="")
                        $d = "inline";
                    else
                        $d = "none";
                ?>
            <div id="queue"></div>
            <input id="file_uploadhc" name="file_uploadhc" type="file" multiple="true">    
                <a target="_blank" href="files_hc/<?php echo $obj->file_hc ?>" style="display:<?php echo $d; ?>;cursor:pointer; font-size: 11px;" id="VerHc"><img src="images/pdf.png" />Abrir Archivo</a>
        </div>

    </div>        
        
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
</div>