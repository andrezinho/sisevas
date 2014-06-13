$(function() 
{
    $("#tabs").tabs({ collapsible: false });
    $( "#descripcion" ).focus();
    $( "#idfuentecapacitacion, #idejecapacitacion" ).css({'width':'220px'});
    $( "#idobejtivosemp,#idobejtivoscap" ).css({'width':'520px'});
    //$("#div_activo").buttonset();
    
    $("#table-per").on('click','#addDetail',function(){
        addDetail();
    });
    
    $("#table-detalle").on('click','.boton-delete',function(){var v = $(this).parent().parent().remove();})
    
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
    html += '<td>'+desc+'<input type="hidden" name="idobejtivosemp[]" value="'+idobejtivosemp+'" /></td>';
    html += '<td align="center"><a class="box-boton boton-delete" href="#" title="Quitar" ></a></td>';
    html += '</tr>';    
    $("#table-detalle").find('tbody').append(html);

}

function save()
{
  bval = true;        
  bval = bval && $( "#descripcion" ).required();        
  //bval = bval && $( "#orden" ).required();
  var str = $("#frm_rutas").serialize();
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