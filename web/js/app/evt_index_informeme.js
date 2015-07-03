$(function() 
{

    $("#list").on('click', '.printer', function() {
        var i = $(this).attr("id");
        i = i.split('-');
        var id = i[1];        
        //alert(id);
        var ventana=window.open('index.php?controller=informeme&action=printer&id='+id, 'scrollbars=yes, status=yes,location=yes'); 
        ventana.focus();
        
        
    });

});