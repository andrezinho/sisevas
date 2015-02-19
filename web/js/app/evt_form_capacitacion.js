$(function() 
{   
    $("#tabs").tabs({ collapsible: false });
    $( "#descripcion" ).focus();
    $( "#dos" ).css({'width':'700px'});
    $( "#idfuentecapacitacion, #idejecapacitacion" ).css({'width':'210px'});
    $( "#idperfil, #idmetodoscapacitacion  " ).css({'width':'220px'});
    $( "#fechacap" ).datepicker({dateFormat:'dd/mm/yy','changeMonth':true,'changeYear':true});
    $( "#idobejtivosemp,#idobejtivoscap" ).css({'width':'550px'});
    
    $("#table-per").on('click','#addDetail',function(){
        addDetail();
    });
    
    $("#table-detalle").on('click','.boton-delete',function(){var v = $(this).parent().parent().remove();})
    
    var idcap=$("#idcapacitacion").val();
    if(idcap == '')
    {load_correlativo(8);}
    
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
            
            return false;
        }
    }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {        
        return $( "<li></li>" )
            .data( "item.autocomplete", item )
            .append( "<a>"+ item.descripcion +"</a>" )
            .appendTo(ul);
      };
    
});

function load_correlativo(idtp)
{
    $.get('index.php','controller=tipodocumento&action=Correlativo&idtp='+idtp,function(r){
        $("#correlativo").val(r.correlativo);
        $("#codigo").val(r.correlativo);
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
    bval = bval && $( "#tema" ).required();
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

