jQuery(function(){
    $('.tabs a:not(.not-ajax)').live('click',function(){
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
    
    $('#conteneur a:not(.not-ajax)').live('click',function(){
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
       
    $('select#matieres, select#CourClasseId').live('click', function(data){
            var classe = $('select#CourClasseId option:selected').val();
            var value = $('select#matieres option:selected').val();
            var url = "/themes/selectbox/"+classe+"/"+value;

            if(value != 0){
                $("#AjoutMatiere").fadeOut();
                $("#NewMatiere").val('');
                $("#NewTheme").val('');
                $("#AjoutTheme").fadeOut();  

                $.get(url, function(data) {
                  $('#loader').show();
                  $('#ListeTheme').show();
                  $('#CourThemeId').html(data);
                  $('#loader').fadeOut();
                });

                $('select#CourThemeId').live('click', function(data){
                    var value2 = $('select#CourThemeId option:selected').val();

                    if(value2 != 0){
                        $("#AjoutTheme").fadeOut();
                        $("#NewTheme").val('');
                    }else{
                        $("#AjoutTheme").fadeIn();
                    }
                });

             }else{
                $('#ListeTheme').fadeOut();
                $("#AjoutMatiere").fadeIn();
                $("#AjoutTheme").fadeIn();                  
             }
   });
});