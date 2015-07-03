$(function() 
{   
    $("#descripcion" ).focus();
    $("#estados").buttonset();
    $("#idlineaaccion").css("width","405px");
});
function save()
{
  bval = true;        
  bval = bval && $( "#descripcion" ).required();
  var str = $("#frm_temas").serialize();
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