$(function() 
{	
	
	$("#list").on('click','.finalizar',function(){
		var i = $(this).attr("id");
		i = i.split('-');
		i = i[1];
		if(confirm('Realmente deseas dar por finalizado esta capacitacion?'))
		{			
			$.post('index.php','controller=capacitacion&action=end&i='+i,function(r)
			{
				if(r[0]==1)	gridReload();
					else alert('Ha ocurrido un error, vuelve a intentarlo.');
			},'json');
		}
	});	

	$("#list").on('click', '.printer', function() {
        var i = $(this).attr("id");
        i = i.split('-');
        id = i[1];        
        alert(id);
        var ventana=window.open('index.php?controller=capacitacionasig&action=printer&id='+id, 'scrollbars=yes, status=yes,location=yes'); 
        ventana.focus();
        
        
    });

});