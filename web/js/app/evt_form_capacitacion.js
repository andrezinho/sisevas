$(function() 
{   
    $( "#tabs").tabs({ collapsible: false });
    $( "#descripcion" ).focus();
    $( "#dos" ).css({'width':'700px'});
    $( "#idfuentecapacitacion, #idperfil" ).css({'width':'210px'});
    $( "#idmetodoscapacitacion" ).css({'width':'430px'});
    $( "#idejecapacitacion" ).css({'width':'250px'});
    $( "#fechacap" ).datepicker({dateFormat:'dd/mm/yy','changeMonth':true,'changeYear':true});
    $( "#idobejtivosemp, #idobejtivoscap, #idtema" ).css({'width':'550px'});
    
    $("#table-per").on('click','#addDetail',function(){
        addDetail();
    });
    
    $("#table-detalle").on('click','.boton-delete',function(){var v = $(this).parent().parent().remove();})
    
    var idcap=$("#idcapacitacion").val();
    var idlin= $("#idlineaaccion").val();
    if(idcap == '')
    {load_correlativo(8);}else{ loadTemas(idlin) }
    
    //buscar LINEAS DE ACCION
    $("#lineaaccion").autocomplete({        
        minLength: 0,
        source: 'index.php?controller=lineaaccion&action=get&tipo=2',
        focus: function( event, ui ) 
        {
            $( "#lineaaccion" ).val( ui.item.descripcion );
            return false;
        },
        select: function( event, ui ) 
        {
            $("#idlineaaccion").val(ui.item.idlineaaccion);            
            $("#lineaaccion").val( ui.item.descripcion);
            loadTemas(ui.item.idlineaaccion);
            return false;
        }
    }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {        
        return $( "<li></li>" )
            .data( "item.autocomplete", item )
            .append( "<a>"+ item.descripcion +"</a>" )
            .appendTo(ul);
      };
      
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

function load_correlativo(idtp)
{
    $.get('index.php','controller=tipodocumento&action=Correlativo&idtp='+idtp,function(r){
        $("#correlativo").val(r.correlativo);
        $("#codigo").val(r.correlativo);
    },'json');
}

function loadTemas(idl)
{
    var idt= $("#idtemaselect").val();
    //alert(idl);
    $.get('index.php','idlinea='+idl+'&controller=lineaaccion&action=getTemas',function(r){
        var options = "<option value='0'>.:: Seleccione ::.</option>";
        $.each(r,function(i,j){
            var sel = '';
            var id= j['id']; //alert(id);
            if (idt == id){ sel = "selected='selected' "; }
            options += "<option "+sel+" value='"+j['id']+"'>"+j['descripcion']+"</option>";
        });						
        $("#idtema").empty().append(options);
    },'json');
    
}
    
function addDetail()
{
  
      bval = true;
      bval = bval && $("#idobejtivosemp").required();      

      if(!bval) return 0;
        idobjemp= $("#idobejtivosemp").val(),
        desc = $("#idobejtivosemp option:selected").html()        
       
        addDetalle(idobjemp,desc);
        
}

function addDetalle(idobjemp,desc)
{     
    var html = '';
    html += '<tr class="tr-detalle">';  
    html += '<td>'+desc+'<input type="hidden" name="idobejtivosempresa[]" value="'+idobjemp+'" /></td>';
    html += '<td align="center"><a class="box-boton boton-delete" href="#" title="Quitar" ></a></td>';
    html += '</tr>';    
    $("#table-detalle").find('tbody').append(html);

}

function save()
{
    bval = true;
    bval = bval && $( "#idfuentecapacitacion" ).required();        
    bval = bval && $( "#idejecapacitacion" ).required();
    bval = bval && $( "#lineaaccion" ).required();        
    //bval = bval && $( "#tema" ).required();    
    bval = bval && $( "#idobejtivoscap" ).required();
    bval = bval && $( "#idmetodoscapacitacion" ).required();
    bval = bval && $( "#idperfil" ).required();
    
    var str = $("#frm_cap").serialize();
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

