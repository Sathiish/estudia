jQuery(function(){
    $('.tabs a').live('click',function(){
        event.preventDefault();
        var e = $(this); 
        var url = e.attr('href');
      
        $.ajax({
            type: 'GET',
            url: url,
            success: function(data){
            	$('#conteneur').html(data);
            }
            
        });
    });
    
    $('#conteneur a').live('click',function(){
        event.preventDefault();
        var e = $(this); 
        var url = e.attr('href');
        
        $.ajax({
            type: 'GET',
            url: url,
            success: function(data){
            	$('#conteneur').html(data);
            }
            
        });
    });
});