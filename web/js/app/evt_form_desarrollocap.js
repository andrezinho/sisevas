$(function() 
{   
    
    $("#tabs").tabs({ collapsible: false });
    $( "#acuerdo" ).focus();    
    $( "#idpersonal" ).css({'width':'250px'});
    $( "#fechacap" ).datepicker({dateFormat:'dd/mm/yy','changeMonth':true,'changeYear':true});
    
    $( "#estados").buttonset();
    
    $("#table-per").on('click','#addDetail',function(){
        addDetail();
    });
    
    $("#table-detalle").on('click','.boton-delete',function(){var v = $(this).parent().parent().remove();})
    
    var idcap=$("#idcapacitacion").val();
    if(idcap != '')
    {load_correlativo(9);}
    
    
    
});

function load_correlativo(idtp)
{   
    var idcap = $("#idcapacitacion").val();
    
    $.get('index.php','controller=desarrollocap&action=VerNroActa&idcap='+idcap,function(rs){
        //alert(rs.nroacta);
        if(rs.nroacta== undefined)
        {
            $.get('index.php','controller=tipodocumento&action=Correlativo&idtp='+idtp,function(r){
                $("#nroacta").val(r.correlativo);
            },'json');
        }
        
    },'json');
}

function addDetail()
{  
      bval = true;
      bval = bval && $("#acuerdo").required();
      if(!bval) return 0;
        ac = $("#acuerdo").val(),
        idp= $("#idpersonal").val(),
        per= $("#idpersonal option:selected").html()        
       
        addDetalle(ac, idp,per);
        
}

function addDetalle(ac, idp, per)
{    
    if(idp=='')
    {idp=0; per='NINGUNO';}
    var html = '';
    html += '<tr class="tr-detalle" style="height: 23px;">';  
    html += '<td>'+ac+'<input type="hidden" name="acuerdocap[]" value="'+ac+'" /></td>';
    html += '<td>'+per+'<input type="hidden" name="idasistente[]" value="'+idp+'" /></td>';
    html += '<td align="center"><a class="box-boton boton-delete" href="#" title="Quitar" ></a></td>';
    html += '</tr>';    
    $("#table-detalle").find('tbody').append(html);
    
    $("#acuerdo").val('');
    $("#idpersonal").val('');
}

function save()
{
    bval = true;
    bval = bval && $( "#idfuentecapacitacion" ).required();        
    bval = bval && $( "#idejecapacitacion" ).required();        
    bval = bval && $( "#tema" ).required();
    bval = bval && $( "#idobejtivoscap" ).required();
    bval = bval && $( "#idmetodoscapacitacion" ).required();
    bval = bval && $( "#idperfil" ).required();
    
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

