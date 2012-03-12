jQuery(function(){       
    $('#classement select#matieres, #classement select#ThemeClasseId').live('click', function(data){
            var classe = $('select#ThemeClasseId option:selected').val();
            var value = $('select#matieres option:selected').val();
            var url = "/themes/selectbox/"+classe+"/"+value;

            $("#classement-annuler").show();

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

                $('#classement select#CourThemeId').live('click', function(data){
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
            
        
//            $('.tag a').live('click',function(){
//                var e = $(this);
//                $.get(e.attr('href'));
//                e.parent().fadeOut();
//                return false;
//            });
//
//            $('.TagTag a').live('click',function(){
//                var e = $(this);
//                var page = <?php echo $this->data['Cour']['id']; ?>;
//                var url = e.attr('href')+'/'+page;
//                $.get(url, function(data) {
//                  $("#tags").html(data);
//                  $("#TagTag").attr('value', '');
//                  $("#ul_TagTag").hide();
//                });
//
//                return false;
//            });
                        
    $('#classement a#classement-button').live('click',function(){
        $("#matieres").show();
        $("#classement-button").hide();
        $("#classement-submit").show();
        $("#classement-annuler").show();
        $('#modifierClasse').show();  
        return false;
    });

    $('#classement a#classement-annuler').live('click',function(){
        $("#matieres").hide();
        $("#modifierClasse").hide();
        $("#classement-annuler").hide();
        $("#classement-button").show();
        $("#classement-submit").hide();
        $("#ListeTheme").hide();
        $("#AjoutMatiere").fadeOut();
        $("#NewMatiere").val('');
        $("#NewTheme").val('');
        $("#AjoutTheme").fadeOut(); 

        return false;
    });

    $('a.ajax').live('click',function(){
        event.preventDefault();
        
        var e = $(this);
        var url = e.attr('href');
        $.get(url, function(data) {
          e.parent().append(data);
        });

        return false;
    });

    $('a.handlediv').live('click',function(){
        event.preventDefault();
        var e = $(this).parent();
        e.find('div').slideToggle('');
    });


    $('#help').live('click',function(){
   //console.log(window);
   event.preventDefault();
       // $(window).load(function(){
         //   $(this).joyride();
        //});
   });


});

        
var isCtrl = false;$(document).keyup(function (e) {
if(e.which == 17) isCtrl=false;
}).keydown(function (e) {
    if(e.which == 17) isCtrl=true;
    if(e.which == 83 && isCtrl == true) {
        $('.submit input').click();
        return false;
 }
});