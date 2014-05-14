$(function() 
{    
    $( "#descripcion" ).focus();
    $( "#idtipovivienda" ).css({'width':'210px'});
    $("#div_activo").buttonset();
    
    $('#file_upload').uploadify({
            'formData'     : {
                    'timestamp' : '44',
                    'token'     : '33',
                    'controller': 'Personal',
                    'action':'loadfile'
            },
            'buttonText': 'Archivo',
            'swf'      : 'uploadify.swf',
            'uploader' : 'index.php?controller=Personal&action=loadfile',
            onUploadSuccess : function(file, data, response) {
                        if(response)
                        {
                            
                            r = data.split("###");
                            if(r[0]==1)
                            {
                                alert('El archivo fue subido correctamente');
                                $("#archivo").val(r[1]);
                                $("#VerImagennn").attr("href","files/"+r[1]);
                                $("#VerImagennn").css("display","inline");
                            }
                            else 
                            {
                                alert(r[1]+' '+data);
                            }                            
                        }
                        else 
                        {
                            alert("Ha ocurrido un error al intentar subir el archivo "+file.name);
                        }
                        
                    }
    });
});

function save()
{
  bval = true;        
  bval = bval && $( "#descripcion" ).required();
  var str = $("#frm").serialize();
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