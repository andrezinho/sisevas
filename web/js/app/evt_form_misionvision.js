$(function() 
{    
    $( "#descripcion" ).focus();
    $("#tabs").tabs({ collapsible: false }); 
    $("#div_activo").buttonset();
    
    $('#file_upload').uploadify({
            'formData'     : {
                    'timestamp' : '44',
                    'token'     : '33',
                    'controller': 'misionvision',
                    'action':'loadfile'
            },
            'buttonText': 'Subir Img',
            'swf'      : 'uploadify.swf',
            'uploader' : 'index.php?controller=misionvision&action=loadfile',
            onUploadSuccess : function(file, data, response) {
                        if(response)
                        {
                            
                            r = data.split("###");
                            if(r[0]==1)
                            {
                                alert('El archivo fue subido correctamente');
                                $("#archivo").val(r[1]);
                                $("#VerImagennn").attr("href","images/index/"+r[1]);
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
    
    $('#file_upload_v').uploadify({
            'formData'     : {
                    'timestamp' : '44',
                    'token'     : '33',
                    'controller': 'misionvision',
                    'action':'loadfile_v'
            },
            'buttonText': 'Subir Img',
            'swf'      : 'uploadify.swf',
            'uploader' : 'index.php?controller=misionvision&action=loadfile_v',
            onUploadSuccess : function(file, data, response) {
                        if(response)
                        {
                            
                            r = data.split("###");
                            if(r[0]==1)
                            {
                                alert('El archivo fue subido correctamente');
                                $("#archivo_v").val(r[1]);
                                $("#VerImg").attr("href","images/index/"+r[1]);
                                $("#VerImg").css("display","inline");
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