$(function() 
{
    $("#tabs").tabs({ collapsible: false });
    $( "#descripcion" ).focus();
    $( "#dos" ).css({'width':'700px'});
    $( "#idfuentecapacitacion, #idejecapacitacion" ).css({'width':'200px'});
    $( "#idperfil, #idtipopersonal, #idmetodoscapacitacion  " ).css({'width':'180px'});
    $( "#fechacap" ).datepicker({dateFormat:'dd/mm/yy','changeMonth':true,'changeYear':true});
    $( "#idobejtivosemp,#idobejtivoscap" ).css({'width':'550px'});
    //$("#div_activo").buttonset();
    
    $("#table-per").on('click','#addDetail',function(){
        addDetail();
    });
    
    $("#table-detalle").on('click','.boton-delete',function(){var v = $(this).parent().parent().remove();})
    
    //buscar cliente
    $("#expositor").autocomplete({        
        minLength: 0,
        source: 'index.php?controller=personal&action=get&tipo=2',
        focus: function( event, ui ) 
        {
            $( "#expositor" ).val( ui.item.nompersonal );
            return false;
        },
        select: function( event, ui ) 
        {
            $("#idpersonal").val(ui.item.idpersonal);
            $( "#emailexp" ).val( ui.item.mail );
            $( "#expositor" ).val( ui.item.nompersonal );
            return false;
        }
    }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {        
        return $( "<li></li>" )
            .data( "item.autocomplete", item )
            .append( "<a>"+ item.nompersonal +"</a>" )
            .appendTo(ul);
      };
    
});

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
    html += '<td>'+desc+'<input type="hidden" name="idobejtivosemp[]" value="'+idobjemp+'" /></td>';
    html += '<td align="center"><a class="box-boton boton-delete" href="#" title="Quitar" ></a></td>';
    html += '</tr>';    
    $("#table-detalle").find('tbody').append(html);

}

function save()
{
  bval = true;        
  bval = bval && $( "#descripcion" ).required();        
  //bval = bval && $( "#orden" ).required();
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