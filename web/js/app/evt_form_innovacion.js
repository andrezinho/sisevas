$(function() 
{    
    $("#descripcion").focus();
    $("#idpersonal").css({'width':'230px'});
    $("#fechain").datepicker({dateFormat:'dd/mm/yy','changeMonth':true,'changeYear':true});
    $("#div_activo").buttonset();
});

function save()
{
  bval = true;
  bval = bval && $( "#idpersonal" ).required();   
  bval = bval && $( "#descripcion" ).required();        
  
  var str = $("#frm_innovacion").serialize();
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