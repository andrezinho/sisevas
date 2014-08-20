$(function() 
{
    $("#tabs").tabs({ collapsible: false });
    $( "#descripcion" ).focus();
    $( "#dos" ).css({'width':'700px'});
    $( "#idfuentecapacitacion, #idejecapacitacion, #idpersonalasig" ).css({'width':'200px'});
    $( "#idmetodoscapacitacion" ).css({'width':'270px'});    
    $( "#idperfil").css({'width':'200px'})
    $( "#idtipoalcance").css({'width':'120px'})
    $( "#fechacap" ).datepicker({dateFormat:'dd/mm/yy','changeMonth':true,'changeYear':true});
    
    $( "#idobejtivosemp,#idobejtivoscap" ).css({'width':'550px'});
    $("#estados").buttonset();
    
    $("#table-per").on('click','#addDetail',function(){
        addDetail();
    });
    
    $("#table-detalle").on('click','.boton-delete',function(){var v = $(this).parent().parent().remove();})
    
    //buscar cliente
    $("#expositordni").autocomplete({        
        minLength: 0,
        source: 'index.php?controller=personal&action=get&tipo=1',
        focus: function( event, ui ) 
        {
            $( "#expositordni" ).val( ui.item.dni );
            return false;
        },
        select: function( event, ui ) 
        {
            $("#expositordni").val(ui.item.dni);
            $("#idpersonal").val(ui.item.idpersonal);            
            $( "#nombresexpositor").val( ui.item.nombres);
            $( "#apellidosexpositor").val( ui.item.apellidos);
            $( "#emailexp" ).val( ui.item.mail );
            return false;
        }
    }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {        
        return $( "<li></li>" )
            .data( "item.autocomplete", item )
            .append( "<a>"+ item.dni +" - " + item.nombres + " "+item.apellidos + "</a>" )
            .appendTo(ul);
      };
      
    
    $("#table-pers").on('click','#addDetails',function(){
        addDetails();
    });
    
    $("#table-detalles").on('click','.boton-deletes',function(){var v = $(this).parent().parent().remove();})
    
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
    html += '<tr class="tr-detalle" style="height: 20px">';  
    html += '<td>'+desc+'<input type="hidden" name="idobejtivosemp[]" value="'+idobjemp+'" /></td>';
    html += '<td align="center"><a class="box-boton boton-delete" href="#" title="Quitar" ></a></td>';
    html += '</tr>';    
    $("#table-detalle").find('tbody').append(html);

}

/**/
function addDetails()
{
  
      bval = true;
      bval = bval && $("#idcapacitacion").required();
      bval = bval && $("#idpersonalasig").required();
      bval = bval && $("#idtipoalcance").required();
            
      if(!bval) return 0;
        idcap =$("#idcapacitacion").val(),        
        iddest =$("#idpersonalasig").val(),            
        dest = $("#idpersonalasig option:selected").html(),
        idalc =$("#idtipoalcance").val(),            
        alc = $("#idtipoalcance option:selected").html(),
       
        addDetalles(idcap,iddest,dest,idalc,alc);
        
}

function addDetalles(idcap,iddest,dest,idalc,alc)
{
        
      var html = '';
      html += '<tr class="tr-detalle" style="height: 20px">';
      html += '<td>'+dest+'<input type="hidden" name="idpersonalasignado[]" value="'+iddest+'" /></td>'
      html += '<td>'+alc+'<input type="hidden" name="idtipoalcance[]" value="'+idalc+'" /></td>';
      html += '<td align="center"><a class="box-boton boton-delete" href="#" title="Quitar" ></a></td>';
      html += '</tr>';    
      $("#table-detalles").find('tbody').append(html);

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