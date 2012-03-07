<div id="dialog-form" title="Contacter des professeurs"></div>

<div class="sidebar" style="margin-top:-5px">
    <div class="sidebar-bloc">
        <h3>Trouver un professeur</h3>
        <a href="" class="handlediv" title="Agrandir"></a>
        <div class="inside">
            <?php echo $this->Form->create('Prospect', array('url' => '/prospects/contact/0')); ?>
            <?php echo $this->element('matiere_liste', array('cache'=>'+1 week')); ?>
            <?php echo $this->Form->input('zip', array('label' => 'Votre code postal')); ?>
            <p></p>
            <?php echo $this->Form->end('Chercher un professeur', array('class' => 'modifier')); ?>
            <div class="clr"></div>
        </div>
    </div>
    
<!--    <div class="sidebar-bloc">
        <h3>Chercher sur ZeSchool</h3>
        <a href="" class="handlediv" title="Agrandir"></a>
        <div class="inside">
            <?php //echo $this->Form->create('Recherche'); ?>
            <?php //echo $this->element('matiere_liste', array('cache'=>'+1 week')); ?>
            
            <div id="ListeTheme" style="display:none">
                <label for="RechercheThemeId">Thème</label>
                <select name="data[Recherche][theme_id]" id="RechercheThemeId" style="max-width: 220px"></select>
                <span id="loader" class="loader"><?php //echo $this->Html->image("loader.gif", array( "alt"=>"loading")); ?></span>
            </div>
            
            
            <p class="bold">Vous recherchez :</p>
            <input type="hidden" name="data['Recherche']['type']" id="Type_" value="0" />
            <p class="label-inline">
                <input type="checkbox" name="data['Recherche']['type'][]" value="cours" id="TypeCours" />
                <label for="TypeCours">Cours</label>
                <input type="checkbox" name="data['Recherche']['type'][]" value="quiz" id="TypeQuiz" />
                <label for="TypeQuiz">Exercice</label>
            </p>
           
            
            <?php //echo $this->Form->end('Chercher maintenant', array('class' => 'modifier')); ?>
            <div class="clr"></div>
        </div>
    </div>-->
    
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/themes/base/jquery-ui.css" type="text/css" media="all" />
<?php echo $this->Html->scriptStart(array('inline'=>false)); ?>
$(function(){
    $('#RechercheMatiere').live('click', function(data){
        var value = $('select#RechercheMatiere option:selected').val();
        var url = "/themes/selectbox/"+value+"/recherche";

        if(value != 0){ 
            $.get(url, function(data) {
              $('#loader').show();
              $('#ListeTheme').show();
              $('#RechercheThemeId').html(data);
              $('#loader').fadeOut();
            });
        }else{
            $('#ListeTheme').fadeOut();                 
         }
    });
    
    $( "#dialog-form" ).dialog({
			autoOpen: false,
			height: 540,
			width: 560,
			modal: true,
			buttons: {
				"Envoyer ma demande": function() {
                                    page = ($(this).attr("action")); 
                                    var post=$("#ProspectContactForm").serialize();
                                    $.post("/prospects/contact/",post,function(html){
                                        $("#dialog-form").empty();
                                        $("#dialog-form").append(html);
                                                                                
                                });
				},
				Fermer: function() {
					$( this ).dialog( "close" );
				}
			},
			close: function() {
				allFields.val( "" ).removeClass( "ui-state-error" );
			}
		});

		$( "#ProspectShowForm").live('submit', function() {
                        $( "#dialog-form" ).dialog( "open" );
                        page = ($(this).attr("action")); 
                        var post=$("#ProspectShowForm").serialize();
                        $.post("/prospects/contact/0",post,function(html){
                            $("#dialog-form").empty();
                                $("#dialog-form").append(html);
                                });
                        return false;
                });
});
            
<?php echo $this->Html->scriptEnd(); ?>