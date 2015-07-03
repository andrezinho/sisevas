$(function() 
{   
    $("#tabs").tabs({ collapsible: false });
    $( "#descripcion" ).focus();
    $( "#idmediosverificacion" ).css({'width':'700px'});
    $( "#idfuncionesuop" ).css({'width':'800px', 'margin-left':'50px'});
    $( "#idpersonal" ).css({'width':'280px'});
    $( "#idconsultorio" ).css({'width':'220px'});
    $( "#fechaini, #fechafin" ).datepicker({dateFormat:'dd/mm/yy','changeMonth':true,'changeYear':true});
    
    $("#dos").on('click','#addDetail',function(){
        addDetail();
    });
    
    $("#table-detalle").on('click','.boton-delete',function(){var v = $(this).parent().parent().remove();})
        
    var idinf=$("#idinforme").val();
    var idcon=$("#consultorio").val();
    var idusu=$("#idusuario").val();
    
    if(idinf== '')
    {
        var tp=0;
        $("#idconsultorio").val(idcon);
        loadPersonal(tp, idcon, idusu);
        
    }else
        {
            var tp=1;
            $("#consultorio").val(idcon);
            loadPersonal(tp, idcon, idusu);            
        }
    
    $("#idconsultorio").change(function(){
        var id=$(this).val();
        $("#consultorio").val(id);
        if(id!='')
        {
            tp=1;
            var usu= 0;
            loadPersonal(tp,id, usu);
        }
        
    });
    
    $("#idpersonal").change(function(){
        var tp=0;
        var id  = $(this).val();
        var idc = $("#idconsultorio").val();
        var fechai= $("#fechaini").val();
        var fechaf= $("#fechafin").val();
        
        if(idinf=='')
        {
            if(id!='')
            {
                tp=0;
                load_correlativo(id, idc);                
                loadTareas(id, fechai, fechaf, idc);
            }
        }
                
    });
    
    
});

function load_correlativo(id, idc)
{
    $.get('index.php','controller=informeme&action=correlativo&idc='+idc+'&idper='+id,function(r){
        if(r.correlativo!='')
        {
            $("#codigo").val(r.codigo);
            $("#correlativo").val(r.correlativo);
        }            
    },'json');
}

/**/
function loadPersonal(tp, idc, usu)
{
    //alert(tp);
    if(tp==0)
        {
            $.get('index.php','idc='+idc+'&idusu='+usu+'&controller=personal&action=getPersonalxArea',function(r){
                var options = "<option value='0'>.:: Seleccione ::.</option>";
                //var options = "";
                $.each(r,function(i,j){
                    options += "<option value='"+j['idpersonal']+"'>"+j['personal']+"</option>";
                });
                $("#idpersonal").empty().append(options);
            },'json');
        }
        
    if(tp==1)
        {
            $.get('index.php','idc='+idc+'&controller=personal&action=getPersonalxArea',function(r){
                var options = "<option value='0'>.:: Seleccione ::.</option>";
                $.each(r,function(i,j){
                    var sel = '';
                    var id= j['idpersonal']; 
                    //alert(usu);
                    if (usu == id){ sel = "selected='selected' "; }
                    options += "<option "+sel+" value='"+j['idpersonal']+"'>"+j['personal']+"</option>";
                });						
                $("#idpersonal").empty().append(options);
            },'json');
        }
}

function loadTareas(id, fechai, fechaf, idc)
{
    if(idc==2)
    {
        $.get('index.php','idc='+idc+'&idper='+id+'&fechai='+fechai+'&fechaf='+fechaf+'&controller=tareas&action=getTareas',function(r){
            //alert(r);        
            var html = ''; var ii=0;
            $.each(r,function(i,j){
                ii++;
                html += '<tr class="tr-detalle" style="height:23px;">';
                    html += '<td align="center">'+ii+'</td>';
                    html += '<td>'+j['tarea']+'<input type="hidden" name="idtareasdet[]" value="'+j['id']+'" /></td>';
                    html += '<td>'+j['eje']+'</td>';
                    html += '<td>'+j['obj']+'</td>';                
                    html += '<td align="center"><input type="text" name="gradodet[]" value="'+j['grado']+'" class="text ui-widget-content ui-corner-all" style="width:40px; text-align:center" /></td>';
                    html += '<td align="center"><a class="box-boton boton-delete" href="#" title="Quitar" ></a></td>';
                html += '</tr>';
            });            
            $("#table-detalle").find('tbody').empty().append(html);
        },'json');
    }else
    {
        $.get('index.php','idper='+id+'&fechai='+fechai+'&fechaf='+fechaf+'&controller=tareas&action=getTareas',function(r){
            //alert(r);        
            var html = ''; var ii=0;
            $.each(r,function(i,j){
                ii++;
                html += '<tr class="tr-detalle" style="height:23px;">';
                    html += '<td align="center">'+ii+'</td>';
                    html += '<td>'+j['tarea']+'<input type="hidden" name="idtareasdet[]" value="'+j['id']+'" /></td>';
                    html += '<td>'+j['eje']+'</td>';
                    html += '<td>'+j['obj']+'</td>';                
                    html += '<td align="center"><input type="text" name="gradodet[]" value="'+j['grado']+'" class="text ui-widget-content ui-corner-all" style="width:40px; text-align:center" /></td>';
                    html += '<td align="center"><a class="box-boton boton-delete" href="#" title="Quitar" ></a></td>';
                html += '</tr>';
            });            
            $("#table-detalle").find('tbody').empty().append(html);
        },'json');
    }
}

function addDetail()
{  
    bval = true;
    bval = bval && $("#tareas").required();      

    if(!bval) return 0;
      desc= $("#tareas").val(),
      //desc = $("#idobejtivosemp option:selected").html()        

      addDetalle(desc);
        
}

function addDetalle(desc)
{     
    var html = '';
    html += '<tr class="tr-detalle" style="height:23px;">';  
    html += '<td>'+desc+'<input type="hidden" name="tareasdet[]" value="'+desc+'" /></td>';
    html += '<td align="center"><a class="box-boton boton-delete" href="#" title="Quitar" ></a></td>';
    html += '</tr>';    
    $("#table-detalle").find('tbody').append(html);
    $("#tareas").val('');
}

function save()
{
    bval = true;
    bval = bval && $( "#fechaini" ).required();
    bval = bval && $( "#fechafin" ).required();
    bval = bval && $( "#codigo" ).required();
    bval = bval && $( "#idconsultorio" ).required();
    bval = bval && $( "#idpersonal" ).required();       
    bval = bval && $( "#idobejtivosemp" ).required();
    bval = bval && $( "#idejecap" ).required();
    bval = bval && $( "#idfuncionesuop" ).required();
    bval = bval && $( "#idmediosverificacion" ).required();
    bval = bval && $( "#indicador" ).required();
    bval = bval && $( "#gradoavance" ).required();
    
    var str = $("#frm_inf").serialize();
    if ( bval ) 
    {
      $.post('index.php',str,function(res)
      {
        if(res[0]==1){
          $("#box-frm").dialog("close");
          gridReload(); 
        }
        else
        {
          alert(res[1]);
        }
        
      },'json');
    }
    return false;
}

