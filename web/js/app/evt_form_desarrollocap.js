$(function() 
{   
    
    $("#tabs").tabs({ collapsible: false });
    $( "#acuerdo" ).focus();    
    $( "#idpersonal" ).css({'width':'250px'});
    $( "#fechacap" ).datepicker({dateFormat:'dd/mm/yy','changeMonth':true,'changeYear':true});
    $( "#estados, #todosp").buttonset();
    //$( "#estados").buttonset();
    
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
    
    $.get('index.php','controller=desarrollocap&action=VerNroActa&idcap='+idcap,function(res){
        //alert(res.nroacta);
        if(res.nroacta== 0)
        {
            $.get('index.php','controller=tipodocumento&action=Correlativo&idtp='+idtp,function(r){
                $("#nroacta").val(r.correlativo);
            },'json');
        }
        
    },'json');
}

function verificar(v)
    {
        $("#todosvalor").val(v)
        if(v==1) { $("#idpersonal").val('');$("#idpersonal").attr('disabled',true) }
        else { $("#idpersonal").attr('disabled',false) }
    }
    
function addDetail()
{  
    bval = true;
    bval = bval && $("#acuerdo").required();
    if(!bval) return 0;
    
    ver= $("#todosvalor").val(),
    idcap= $("#idcapacitacion").val(),
    ac = $("#acuerdo").val(),
    idp= '';
    per= $("#personalasist").val()
    
    addDetalle(ver, idcap, ac, idp, per);
        
}

function addDetalle(ver, idcap, ac, idp, per)
{   
    if(ver==0)
    {
        if(idp=='')
        {idp=0;}
        if(per=='')
        {per='';}
        var html = '';
        html += '<tr class="tr-detalle" style="height: 23px;">';  
        html += '<td>'+ac+'<input type="hidden" name="acuerdocap[]" value="'+ac+'" /></td>';
        html += '<td>'+per+'<input type="hidden" name="idasistente[]" value="" />';
        html += '<input type="hidden" name="asistentedet[]" value="'+per+'" /></td>';
        html += '<td align="center"><a class="box-boton boton-delete" href="#" title="Quitar" ></a></td>';
        html += '</tr>';    
        $("#table-detalle").find('tbody').append(html);
    }
    else
        {
            $.get('index.php','controller=personal&action=getListaAsist&idcap='+idcap,function(r){    
                var html = '';
                $.each(r,function(i,j){
                    html += '<tr class="tr-detalle" style="height: 23px;">';  
                    html += '<td>'+ac+'<input type="hidden" name="acuerdocap[]" value="'+ac+'" /></td>';
                    html += '<td>'+j.personal+'<input type="hidden" name="idasistente[]" value="'+j.idpersonal+'" /></td>';
                    html += '<td align="center"><a class="box-boton boton-delete" href="#" title="Quitar" ></a></td>';
                    html += '</tr>';
                });      
                $("#table-detalle").find('tbody').append(html);
            },'json');
        }
        
    
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

