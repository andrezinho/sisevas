$(function() 
{    
    $("#tabs").tabs({ collapsible: false });
    $( "#descripcion" ).focus();
    $( "#dos" ).css({'width':'700px'});
    $( "#idfuentecapacitacion, #idejecapacitacion, #idpersonalasig" ).css({'width':'200px'});
    $( "#idmetodoscapacitacion, #idcatpresupuesto, #idconcepto" ).css({'width':'270px'});    
    $( "#idperfil").css({'width':'200px'})
    $( "#idtipoalcance").css({'width':'120px'})
    $( "#fechacap" ).datepicker({dateFormat:'dd/mm/yy','changeMonth':true,'changeYear':true});
    
    $( "#idobejtivosemp,#idobejtivoscap" ).css({'width':'550px'});
    $( "#estados").buttonset();
    
    $("#table-per").on('click','#addDetail',function(){
        addDetail();
    });
    
    $("#table-detalle").on('click','.boton-delete',function(){var v = $(this).parent().parent().remove();})
    
    //buscar Expositor DNI
    $("#expositordni").autocomplete({        
        minLength: 0,
        source: 'index.php?controller=personal&action=get&tipo=1',
        focus: function( event, ui ) 
        {
            $( "#expositordni" ).val( ui.item.dni );
            return false;
        },
        select: function( event, ui ) 
        {
            $("#expositordni").val(ui.item.dni);
            $("#idpersonal").val(ui.item.idpersonal);            
            $( "#nombresexpositor").val( ui.item.nombres);
            $( "#apellidosexpositor").val( ui.item.apellidos);
            $( "#emailexp" ).val( ui.item.mail );
            return false;
        }
    }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {        
        return $( "<li></li>" )
            .data( "item.autocomplete", item )
            .append( "<a>"+ item.dni +" - " + item.nombres + " "+item.apellidos + "</a>" )
            .appendTo(ul);
    };
      
    //buscar Expositor NOMBRES
    $("#nombresexpositor").autocomplete({        
        minLength: 0,
        source: 'index.php?controller=personal&action=get&tipo=2',
        focus: function( event, ui ) 
        {
            $( "#nombresexpositor" ).val( ui.item.nombres );
            return false;
        },
        select: function( event, ui ) 
        {
            $("#expositordni").val(ui.item.dni);
            $("#idpersonal").val(ui.item.idpersonal);            
            $( "#nombresexpositor").val( ui.item.nombres);
            $( "#apellidosexpositor").val( ui.item.apellidos);
            $( "#emailexp" ).val( ui.item.mail );
            return false;
        }
    }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {        
        return $( "<li></li>" )
            .data( "item.autocomplete", item )
            .append( "<a>"+ item.nombres + " "+item.apellidos + "</a>" )
            .appendTo(ul);
      };
    
    //buscar PERSONAL ASIGNADO A CAPACITACION: NOMBRES
    $("#personalasig").autocomplete({        
        minLength: 0,
        source: 'index.php?controller=personal&action=get&tipo=2',
        focus: function( event, ui ) 
        {
            $( "#personalasig" ).val( ui.item.nombres );
            return false;
        },
        select: function( event, ui ) 
        {
            $("#idpersonalasig").val(ui.item.idpersonal);            
            $( "#personalasig").val( ui.item.nombres+' '+ ui.item.apellidos);
            
            return false;
        }
    }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {        
        return $( "<li></li>" )
            .data( "item.autocomplete", item )
            .append( "<a>"+ item.nombres + " "+item.apellidos + "</a>" )
            .appendTo(ul);
      };
    
    //buscar LINEAS DE ACCION
    $("#lineaaccion").autocomplete({        
        minLength: 0,
        source: 'index.php?controller=lineaaccion&action=get&tipo=2',
        focus: function( event, ui ) 
        {
            $( "#lineaaccion" ).val( ui.item.descripcion );
            return false;
        },
        select: function( event, ui ) 
        {
            $("#idlineaaccion").val(ui.item.idlineaaccion);            
            $("#lineaaccion").val( ui.item.descripcion);
            
            return false;
        }
    }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {        
        return $( "<li></li>" )
            .data( "item.autocomplete", item )
            .append( "<a>"+ item.descripcion +"</a>" )
            .appendTo(ul);
      };
      
    $("#table-pers").on('click','#addDetails',function(){
        addDetails();
    });
    
    $("#table-detalles").on('click','.boton-deletes',function(){var v = $(this).parent().parent().remove();})
    
    $("#idcatpresupuesto").change(function(){load_conceptos($(this).val()); $("#idconcepto").focus();});
    $("#idunidad_medida").change(function(){UnidadMed($(this).val());});   
    
    /* DETALLE PRESUPUESTO */
    $("#Presupuesto").on('click','#addDetPre',function(){
        addDetPre();
    });
    
    $("#table-detpresupuesto").on('click','.boton-deletesPre',function(){var v = $(this).parent().parent().remove();})
        
    /**/
    
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
    html += '<tr class="tr-detalle" style="height: 20px">';  
    html += '<td>'+desc+'<input type="hidden" name="idobejtivosemp[]" value="'+idobjemp+'" /></td>';
    html += '<td align="center"><a class="box-boton boton-delete" href="#" title="Quitar" ></a></td>';
    html += '</tr>';    
    $("#table-detalle").find('tbody').append(html);

}

/**/
function addDetails()
{
  
      bval = true;
      bval = bval && $("#idcapacitacion").required();
      bval = bval && $("#idpersonalasig").required();
      bval = bval && $("#idtipoalcance").required();
            
      if(!bval) return 0;
        idcap =$("#idcapacitacion").val(),        
        iddest =$("#idpersonalasig").val(),            
        dest = $("#personalasig").val(),
        idalc =$("#idtipoalcance").val(),            
        alc = $("#idtipoalcance option:selected").html(),
       
        addDetalles(idcap,iddest,dest,idalc,alc);
        
}

function addDetalles(idcap,iddest,dest,idalc,alc)
{
        
    var html = '';
    html += '<tr class="tr-detalle" style="height: 20px">';
    html += '<td>'+dest+'<input type="hidden" name="idpersonalasignado[]" value="'+iddest+'" /></td>'
    html += '<td>'+alc+'<input type="hidden" name="idtipoalcance[]" value="'+idalc+'" /></td>';
    html += '<td align="center"><a class="box-boton boton-deletes" href="#" title="Quitar" ></a></td>';
    html += '</tr>';    
    $("#table-detalles").find('tbody').append(html);

    $("#idpersonalasig").val('');
    $("#personalasig").val('');

}

/**/
function load_conceptos(id)
{ 
  if(id!="")
  {    
    $("#idconcepto").empty().append('<option value="">Cargando...</option>');
    $.get('index.php','controller=concepto&action=getList&id='+id,function(r){    
        html = '<option value="0">.:: Seleccione ::.</option>';
        $.each(r,function(i,j){
            html += '<option value="'+j.idconcepto+'">'+j.descripcion+'</option>';
        });      
        $("#idconcepto").empty().append(html);
    },'json');
  }
}

function UnidadMed(Op)
{
    //alert(Op);
    if(Op==1)
    {
        $("#tiempo").attr('disabled',true)        
    }
    else
        {
            $("#tiempo").attr('disabled',false)           
        }
}

/*** PRESUPUESTO *********/
function addDetPre()
{   
    //alert('');
    bval = true;
    bval = bval && $("#idcatpresupuesto").required();
    //bval = bval && $("#idconcepto").required();
    //bval = bval && $("#idunidad_medida").required();
    iduni =$("#idunidad_medida").val();    
    if(iduni==2)
        {bval = bval && $("#tiempo").required();}
    
    if(!bval) return 0;

    idcat =$("#idcatpresupuesto").val(),
    cat   = $("#idcatpresupuesto option:selected").html(),
    idcon =$("#idconcepto").val(),            
    con   = $("#idconcepto option:selected").html(),
    cant  =$("#cantidad").val(),  
    iduni =$("#idunidad_medida").val(),
    uni   = $("#idunidad_medida option:selected").html(),
    tiem  = $("#tiempo").val(),    
    pre   = $("#precio").val(), 
    
    addDetallesP(idcat,cat,idcon,con,cant,iduni,uni,tiem,pre);        
}

function addDetallesP(idcat,cat,idcon,con,cant,iduni,uni,tiem,pre)
{
    //alert('');
    if(tiem==''){
        tiem=0;
        var subtotal= (pre * cant);
        subtotal= subtotal.toFixed(2);
    }else
        {
            var subtotal= (pre * cant * tiem);
            subtotal= subtotal.toFixed(2);
        }
    
    if(iduni==0)
    {
        iduni =0;
        uni   ='Ninguno';
    }
    
    if(idcon==0)
    {
        idcon =0;
        con   ='Ninguno';
    }
    
    var html = '';
    html += '<tr class="tr-detalle" style="height: 20px">';
    html += '<td>'+cat+'<input type="hidden" name="idcatpresupuestodet[]" value="'+idcat+'" /></td>'
    html += '<td>'+con+'<input type="hidden" name="idconceptodet[]" value="'+idcon+'" /></td>';    
    html += '<td align="center">'+tiem+'<input type="hidden" name="tiempodet[]" value="'+tiem+'" /></td>';
    html += '<td align="center">'+uni+'<input type="hidden" name="idunidad_medidadet[]" value="'+iduni+'" /></td>';
    html += '<td align="right">'+cant+'<input type="hidden" name="cantidaddet[]" value="'+cant+'" /></td>';
    html += '<td align="right">'+pre+'<input type="hidden" name="preciodet[]" value="'+pre+'" /></td>';
    html += '<td align="right">'+subtotal+'<input type="hidden" name="subtotal[]" value="'+subtotal+'" /></td>';
    html += '<td align="center"><a class="box-boton boton-deletesPre" href="#" title="Quitar" ></a></td>';
    html += '</tr>';    
    
    $("#table-detpresupuesto").find('tbody').append(html);

}

function save()
{
  bval = true;        
  bval = bval && $("#descripcion" ).required();        
  bval = bval && $("#lineaaccion").required();
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