$(document).ready(function()
	{	
            $("#dialog-reporte").dialog({
                    title:'Elija el Formato del Reporte',
                    autoOpen:false,
                    modal:true
            });
            $("#personal_name").focus();
            $("#load_personal").click(function(){			
                    $("#form-search").submit();
            })

            $("#btn-search-personal").click(function(){	$("header").fadeIn(); $("#personal_name").focus();});
            $("#btn-close-search-personal").click(function(){	$("header").fadeOut(); });
            $("#personal_name").autocomplete({
            minLength: 0,
            source: 'index.php?controller=personal&action=get&tipo=0',
            focus: function( event, ui ) 
            {
                return false;
            },
            select: function( event, ui )
            {
                $("#idp").val(ui.item.idpersonal);
                $("#personal_name" ).val( ui.item.nompersonal );
                $("#load_personal").focus();
                return false;
            }
         }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
            return $( "<li></li>" )
                .data( "item.autocomplete", item )
                .append( "<a>"+ item.dni +" - " + item.nompersonal + "</a>" )
                .appendTo(ul);
          };

            $("#idcompetencia").addClass('select');
            $("#idcompetencia").change(function(){loadAspectos();});
            $("#save_as").click(function(){
                    var v = new Array();
                    $('form').each(function(i,j){
                            var name_all = $(this).attr("id"),
                                    name = name_all.replace('form','r-');									
                            valor = $("input[name='"+name+"']:checked").val();
                            if(typeof(valor)!="undefined")
                                    v.push(valor);
                    });
                    var sendv = json_encode(v),
                            idp   = $("#idpersonal").val();
                    $.post('index.php','controller=evaluacion&action=save&v='+sendv+'&idp='+idp,function(data){
                            if(data[0]=='1')
                    alert("Se ha grabado los cambios satisfactoriamente.");
            else
                    alert(data[1]);
                    },'json')
            });

            $("#reporte_as").click(function()
            {
                    $("#dialog-reporte").dialog('open');			
            });
            $("#reporte_as_excel").click(function(){
                    var idp   = $("#idpersonal").val();
                    popup('index.php?controller=evaluacion&action=reporte_detallado&tipo=excel&idp='+idp,500,500);
            });
        
    $("#reporte_in").click(function(){
  		var idp   = $("#idpersonal").val();
  		popup('index.php?controller=innovacion&action=reporte_detallado&idp='+idp,650,500);
		});

		$("#reporte_me").click(function(){
			var idp   = $("#idpersonal").val();
      var idtp = 1;
			popup('index.php?controller=envio&action=reporte_detallado&idp='+idp+'&idtp='+idtp,650,500);
		});

    $("#reporte_ca").click(function(){
      var idp   = $("#idpersonal").val();
      var idtp = 4;
      popup('index.php?controller=envio&action=reporte_detallado&idp='+idp+'&idtp='+idtp,650,500);
    });

		var $floatingbox = $('#mp-menu'); 
           if($('.container').length > 0)
           {
              var bodyY = parseInt($('.container').offset().top);
              var originalX = $floatingbox.css('margin-left');
              $(window).scroll(function () 
              {                        
                   var scrollY = $(window).scrollTop();
                   var isfixed = $floatingbox.css('position') == 'fixed';
                   if($floatingbox.length > 0){
                      if ( scrollY > bodyY && !isfixed ) 
                      {                                
                                $floatingbox.stop().css({
                                  position: 'fixed',                                  
                                  marginLeft: 0,
                                  top:0
                                });
                        } else if ( scrollY < bodyY && isfixed ) 
                        {
                                  $floatingbox.css({
                                  position: 'absolute',
                                  top:0,
                                  marginLeft: originalX
                        });
                     }		
                   }
              });
            }

		$('.comp-option').click(function(){
			var id = $(this).attr("id");
				id = id.split('-');
				$("#idcompetencia").val(id[1]);
			loadAspectos();
			$('.comp-option').removeClass('com-option-select');
			$(this).addClass('com-option-select');
		});

		$("#barra-session").on('click','.delete',function(){
			
                    var idp = $("#idpersonal").val();
                    var idper = $("#idperiodoactual").val();

                    if(confirm('Realmente deseas borrar la evaluacion?'))
                    {			
                        $.post('index.php','controller=evaluacion&action=deleteeva&idtabs='+idp+'&idper='+idper,function(r)
                        {
                                if(r[0]==1)	gridReload();
                                        else alert('Ha ocurrido un error, vuelve a intentarlo.');
                        },'json');
                    }
		});	


	});
	function loadAspectos()
	{
		var idc = $("#idcompetencia").val(),
			idp = $("#idpersonal").val();
		if(idc!="")
		{
			clearSecctions();
			$.get('index.php','controller=evaluacion&action=getAspectos&idc='+idc+'&idp='+idp,function(data){
				$(".container").append(data);
			});
		}
	};
	function clearSecctions(){$('section').remove();}
	//Funciones del svgcheckbx.js
	function draw( el, type ) 
	{
		var paths = [], pathDef, 
			animDef,
			svg = el.parentNode.querySelector( 'svg' );

		switch( type ) 
		{
			case 'cross': pathDef = pathDefs.cross; animDef = animDefs.cross; break;
			case 'fill': pathDef = pathDefs.fill; animDef = animDefs.fill; break;
			case 'checkmark': pathDef = pathDefs.checkmark; animDef = animDefs.checkmark; break;
			case 'circle': pathDef = pathDefs.circle; animDef = animDefs.circle; break;
			case 'boxfill': pathDef = pathDefs.boxfill; animDef = animDefs.boxfill; break;
			case 'swirl': pathDef = pathDefs.swirl; animDef = animDefs.swirl; break;
			case 'diagonal': pathDef = pathDefs.diagonal; animDef = animDefs.diagonal; break;
			case 'list': pathDef = pathDefs.list; animDef = animDefs.list; break;
		};
		
		paths.push( document.createElementNS('http://www.w3.org/2000/svg', 'path' ) );

		if( type === 'cross' || type === 'list' ) 
		{
			paths.push( document.createElementNS('http://www.w3.org/2000/svg', 'path' ) );
		}
		
		for( var i = 0, len = paths.length; i < len; ++i ) {
			var path = paths[i];
			svg.appendChild( path );

			path.setAttributeNS( null, 'd', pathDef[i] );

			var length = path.getTotalLength();			
			path.style.strokeDasharray = length + ' ' + length;
			if( i === 0 ) {
				path.style.strokeDashoffset = Math.floor( length ) - 1;
			}
			else path.style.strokeDashoffset = length;
			path.getBoundingClientRect();			
			path.style.transition = path.style.WebkitTransition = path.style.MozTransition  = 'stroke-dashoffset ' + animDef.speed + 's ' + animDef.easing + ' ' + i * animDef.speed + 's';			
			path.style.strokeDashoffset = '0';
		}
	}

	function reset( el ) {
		Array.prototype.slice.call( el.parentNode.querySelectorAll( 'svg > path' ) ).forEach( function( el ) { el.parentNode.removeChild( el ); } );
	}

	function resetRadio( el ) {
		Array.prototype.slice.call( document.querySelectorAll( 'input[type="radio"][name="' + el.getAttribute( 'name' ) + '"]' ) ).forEach( function( el ) { 
			var path = el.parentNode.querySelector( 'svg > path' );
			if( path ) {
				path.parentNode.removeChild( path );
			}
		} );
	}