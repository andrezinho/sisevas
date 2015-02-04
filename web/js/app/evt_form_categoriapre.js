$(function() 
{    
    $( "#descripcion" ).focus();    
    $("#estados").buttonset();
    $("#asignacion").on('click','#addDetail',function(){
        addDetail();
    });
    
    $("#table-detalle").on('click','.boton-delete',function(){var v = $(this).parent().parent().remove();})
    
    //Busqueda de Conceptos
    $("#concepto").autocomplete({        
        minLength: 0,
        source: 'index.php?controller=concepto&action=get&tipo=1',
        focus: function( event, ui ) 
        {
            $( "#concepto" ).val( ui.item.dni );
            return false;
        },
        select: function( event, ui ) 
        {
            $("#concepto").val(ui.item.descripcion);
            $("#idconcepto").val(ui.item.idconcepto);
            return false;
        }
    }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {        
        return $( "<li></li>" )
            .data( "item.autocomplete", item )
            .append( "<a>"+ item.descripcion + "</a>" )
            .appendTo(ul);
    };
    
});

function addDetail()
{     
    bval = true;
    bval = bval && $("#idconcepto").required();      

    if(!bval) return 0;
    idconcepto= $("#idconcepto").val(),
    desc = $("#concepto").val()       

    addDetalle(idconcepto,desc);
        
}

function addDetalle(idconcepto,desc)
{     
    var html = '';
    html += '<tr class="tr-detalle" style="height: 20px">';  
    html += '<td>'+desc+'<input type="hidden" name="idconceptodet[]" value="'+idconcepto+'" /></td>';
    html += '<td align="center"><a class="box-boton boton-delete" href="#" title="Quitar" ></a></td>';
    html += '</tr>';    
    $("#table-detalle").find('tbody').append(html);
    
    $("#concepto").val('')
    $("#idconcepto").val('')
}

function save()
{
  bval = true;        
  bval = bval && $( "#descripcion" ).required();        
  //bval = bval && $( "#orden" ).required();
  var str = $("#frm_cat").serialize();
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