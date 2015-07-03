$(function() 
{   
    $("#descripcion").focus();
    $("#estadosnp").buttonset();
    $("#fechareg").datepicker({dateFormat:'dd/mm/yy','changeMonth':true,'changeYear':true});
    $("#idimportancia").css("width","200px");
    $("#idejecapacitacion, #idobejtivosemp").css("width","400px");
    $( "#idmediosverificacion" ).css({'width':'700px'});
    $( "#idfuncionesuop" ).css({'width':'800px', 'margin-left':'50px'});
        
    var idcargo= $("#idcargo").val();
    var idfun  = $("#idfuncion").val();
    loadFunciones(idcargo, idfun);
});

function loadFunciones(idcargo, idfun)
{
    $.get('index.php','idcargo='+idcargo+'&controller=funcionesuop&action=getFuncionesxArea',function(r){
        var options = "<option value='0'>.:: Seleccione Funciones ::.</option>";
        $.each(r,function(i,j){
            var sel = '';
            var id= j['id']; 
            if (idfun == id){ sel = "selected='selected' "; }
            options += "<option "+sel+" value='"+j['id']+"'>"+j['descripcion']+"</option>";
        });						
        $("#idfuncionesuop").empty().append(options);
    },'json');
    
}

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