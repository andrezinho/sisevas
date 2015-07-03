$(function() 
{
    $("#tabs").tabs();
    $("#estados, #todosp").buttonset();
    $("#fechainicio").datepicker({dateFormat:'dd/mm/yy','changeMonth':true,'changeYear':true});
    
    $("#idtipo_documento" ).focus();
    $("#idtipo_documento, #idpersonal, #idcierre, #idtipo_problema, #idperremitente, #idareai, #idpersonalresp" ).css({'width':'230px'});
    
    //Generar correlativo y Cargar Formatos
    $(" #idtipo_documento ").change(function(){
      load_formato($(this).val());
      load_correlativo($(this).val());
    });

    $("#idtipo_problema").change(function(){
        load_problema($(this).val()); 
        $("#idareai").focus();
    });

    $("#table-per").on('click','#addDetail',function(){
        addDetail();
    });
    
    $("#table-detalle").on('click','.boton-deletes',function(){var v = $(this).parent().parent().remove();})
    
    var idtramite= $("#idtramite").val();
    
    $("#nuevotem").click(function(){
        //if (!$('#nuevotem').attr('checked'))
        if($("#nuevotem").is(':checked'))
        { 
            $("#temanuevo").show();
            $("#idtema").val(0);
            $('#idtema').attr('disabled', true);
            $("#tema").val('');
        }
        else { 
            $("#temanuevo").hide();
            $("#idtema").val(0);
            $('#idtema').attr('disabled', false);
            $("#tema").val('');
        }
    })
    
});

function verificar(v)
    {
        $("#todosvalor").val(v)
        if(v==1) { $("#idpersonal").val(''); $("#idpersonal").attr('disabled',true) }
        else { $("#idpersonal").attr('disabled',false) }
    }

function load_formato(idtipodoc)
{   
    //	Memorandun
    if(idtipodoc== 1)
    {    
        $("#load_formato").empty().append('Cargando...');
        $.get('index.php','controller=tipodocumento&action=formatos',function(html){    
            $("#load_formato").empty().append(html);
        }); //'json');
    }
    //Informe de reclamos
    if(idtipodoc== 2)
    {    
        $("#load_formato").empty().append('Cargando...');
        $.get('index.php','controller=tipodocumento&action=formatos1',function(html){    
            $("#load_formato").empty().append(html);
        }); //'json');
    }
    //Servicio no Conforme
    if(idtipodoc== 3)
    {    
        $("#load_formato").empty().append('Cargando...');
        $.get('index.php','controller=tipodocumento&action=formatos2',function(html){    
            $("#load_formato").empty().append(html);
        }); //'json');
    }
    //Carta de felicitación
    if(idtipodoc== 4)
    {    
        $("#load_formato").empty().append('Cargando...');
        $.get('index.php','controller=tipodocumento&action=formatos3&id='+idtipodoc,function(html){    
            $("#load_formato").empty().append(html);
        }); //'json');
    }
    //Carta de cumpleaños
    if(idtipodoc== 5)
    {    
        $("#load_formato").empty().append('Cargando...');
        $.get('index.php','controller=tipodocumento&action=formatos4&id='+idtipodoc,function(html){    
            $("#load_formato").empty().append(html);
        }); //'json');
    }
    //Acta reunion de Gestion
    if(idtipodoc== 10)
    {    
        $("#load_formato").empty().append('Cargando...');
        $.get('index.php','controller=tipodocumento&action=formatos5&id='+idtipodoc,function(html){    
            $("#load_formato").empty().append(html);
        }); //'json');
    }
    //Ronda medica
    if(idtipodoc== 11)
    {    
        $("#load_formato").empty().append('Cargando...');
        $.get('index.php','controller=tipodocumento&action=formatos6&id='+idtipodoc,function(html){    
            $("#load_formato").empty().append(html);
        }); //'json');
    }
    //Ronda ARO
    if(idtipodoc== 12)
    {    
        $("#load_formato").empty().append('Cargando...');
        $.get('index.php','controller=tipodocumento&action=formatos7&id='+idtipodoc,function(html){    
            $("#load_formato").empty().append(html);
        }); //'json');
    }
    
}

function load_correlativo(idtp)
{
    $.get('index.php','controller=tipodocumento&action=Correlativo&idtp='+idtp,function(r){
          
        //$("#serie").val(r.serie);
        //$("#numero").val(r.numero);
        $("#correlativo").val(r.correlativo);
    },'json');
}

function load_problema(idl)
{ 
  if(idl!="")
  {    
    $("#idareai").empty().append('<option value="">Cargando...</option>');
    $.get('index.php','controller=tipoproblema&action=getList&idl='+idl,function(r){    
        html = '<option value="">Seleccione...</option>';
        $.each(r,function(i,j){
          html += '<option value="'+j.idareai+'">'+j.descripcion+'</option>';
        });      
        $("#idareai").empty().append(html);
    },'json');
  }
}

function SaveNexUser()
{
    var dni= $("#dni").val();
    var nom= $("#nom").val();
    var app= $("#app").val();

    $.get('index.php','controller=personal&action=SaveNexUser&dni='+dni+'&nom='+nom+'&app='+app,function(r){    
         
        $("#idareai").empty().append(r.id);
    },'json');
}

function addDetail()
{

    if($("#todosvalor").val()==1)
    {
        
        bval = true;
        bval = bval && $("#idtipoalcance").required();
        if(!bval) return 0;
            idalc =$("#idtipoalcance").val(),            
            alc = $("#idtipoalcance option:selected").html(),
        
        $.get('index.php','controller=personal&action=getListaAsig',function(r){    
            var html = '';
            $.each(r,function(i,j){
                html += '<tr class="tr-detalle" style="height: 20px">';
                html += '<td>'+j.personal+'<input type="hidden" name="idpersonaldet[]" value="'+j.idpersonal+'" /></td>'                
                html += '<td align="center"><a class="box-boton boton-deletes" href="#" title="Quitar" ></a></td>';
                html += '</tr>';
            });      
            $("#table-detalle").find('tbody').append(html);
        },'json');
    
    }
    else
    {
        bval = true;
        bval = bval && $("#idtipo_documento").required();
        bval = bval && $("#correlativo").required();
        //bval = bval && $("#idpersonal").required();

        if(!bval) return 0;        
            iddest =$("#idpersonal").val(),            
            dest = $("#idpersonal option:selected").html(),

        addDetalle(iddest,dest);
    }
    
        
}

function addDetalle(iddest,dest)
{        
    var html = '';
    html += '<tr class="tr-detalle" style="height: 23px;">';
    html += '<td>'+dest+'<input type="hidden" name="idpersonaldet[]" value="'+iddest+'" /></td>';
    html += '<td align="center"><a class="box-boton boton-deletes" href="#" title="Quitar" ></a></td>';
    html += '</tr>';    
    $("#table-detalle").find('tbody').append(html);
}

function save()
{
  bval = true;        
  bval = bval && $( "#idtipo_problema" ).required();
  bval = bval && $( "#idareai" ).required();        
  //bval = bval && $( "#idpersonal" ).required();
  bval = bval && $( "#idcierre" ).required();

  var str = $("#frm_envio").serialize();
  if ( bval ) 
  {
      $.post('index.php',str,function(res)
      {
        if(res[0]==1)
        {
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