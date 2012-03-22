jQuery(function(){
    
    $('a#modifier').live('click', function(data){
        $('a#modifier').hide();
        $('a#annuler').show();
        $('#niveau').hide();
        $('#RessourceNiveau').show();
        
        url = '/ressources/listNiveau';
        
        $.get(url, function(data) {
          $('#RessourceNiveau').html(data);
        });      
        
    });
    
    $('select#RessourceNiveau').live('click', function(data){
        var niveau = $('select#RessourceNiveau option:selected').val();
        if(niveau != "undefined"){
            $('#classe').hide();
            $('#RessourceClasse').show();
        
            var url = "/ressources/listClasse/"+niveau;
            $.get(url, function(data) {
              $('#RessourceClasse').html(data);
            });
        }   
    });
    
    $('select#RessourceClasse').live('click', function(data){
        var classe = $('select#RessourceClasse option:selected').val();
        if(classe != "undefined"){
            $('#matiere').hide();
            $('#RessourceMatiere').show();
            
            var url = "/ressources/listMatiere/"+classe;
            $.get(url, function(data) {
              $('#RessourceMatiere').html(data);
            });
        }
    });

    $('select#RessourceMatiere').live('click', function(data){
        var matiere = $('select#RessourceMatiere option:selected').val();
        if(matiere != "undefined"){
            $('#theme').hide();
            $('#RessourceThemeId').show();
            var url = "/ressources/listTheme/"+matiere;
            $.get(url, function(data) {
              $('#RessourceThemeId').html(data);
            });    
        }

    });
        
    $('select#RessourceThemeId').live('click', function(){
        $('#chapitre-submit').css('visibility','visible');
    });
                            
    $('a#annuler').live('click',function(){
        event.preventDefault();
        $('a#annuler').hide();
        $('a#modifier').show();
        
        $('#chapitre-submit').css('visibility','hidden');
        
        $('#RessourceThemeId').hide();
        $('#theme').show();
        
        $('#RessourceMatiere').hide();
        $('#matiere').show();
        
        $('#RessourceClasse').hide();
        $('#classe').show();
                        
        $('#RessourceNiveau').hide();                      
        $('#niveau').show();
        
        
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