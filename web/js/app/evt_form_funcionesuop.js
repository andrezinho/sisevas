$(function() 
{    
    $( "#descripcion" ).focus
    $( "#idconsultorio, #idcargo, #idejecapacitacion" ).css({'width':'250px'});   
    $("#estados").buttonset();
});

function save()
{
  bval = true;        
  bval = bval && $( "#descripcion" ).required();        
  //bval = bval && $( "#orden" ).required();
  var str = $("#frm_consultorio").serialize();
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