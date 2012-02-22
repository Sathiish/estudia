<?php echo $this->Html->css('form', null, array('inline' => false));?>
<?php $this->Html->script('tiny_mce/tiny_mce.js',array('inline'=>false)); ?>
<?php $this->Html->scriptStart(array('inline'=>false)); ?>
        tinyMCE.init({
                mode : 'textareas',
                theme: 'advanced',               
                plugins: 'inlinepopups,paste,emotions,image',
                entity_encoding : "raw",
                
                theme_advanced_buttons1 : 'bold,italic,underline,|,bullist,numlist,|,justifyleft,justifycenter,justifyright,justifyfull,|,image,|,link,unlink',
                theme_advanced_buttons2 : '',
                theme_advanced_buttons3 : '',
                theme_advanced_buttons4 : '',
                theme_advanced_toolbar_location:'top',
                theme_advanced_statusbar_location : 'bottom',
                theme_advanced_resizing : true,
                width : '675',
                height : '100',
                forced_root_block : false,
                force_br_newlines : true,
                force_p_newlines : false,
                paste_remove_styles : true,
                paste_remove_spans :  true,
                paste_stip_class_attributes : "all",
                image_explorer : '<?php echo $this->Html->url(array('controller'=>'medias','action'=>'message')); ?>',
                image_edit : '<?php echo $this->Html->url(array('controller'=>'medias','action'=>'show')); ?>',
                relative_urls : false,
                content_css : '/css/wysiwyg.css'
        });
        
        function send_to_editor(content){
                var ed = tinyMCE.activeEditor;
                ed.execCommand('mceInsertContent',false,content); 
        }
        
        jQuery(function(){
            $('select#matieres').live('click', function(data){
                var value = $('select#matieres option:selected').val();
                var url = "/themes/selectbox/"+value;
                
                if(value != 0){
                    $("#AjoutMatiere").fadeOut();
                    $("#NewMatiere").val('');
                    $("#NewTheme").val('');
                    $("#AjoutTheme").fadeOut();  

                    $.get(url, function(data) {
                      $('#loader').show();
                      $('#ListeTheme').show();
                      $('#QuizThemeId').html(data);
                      $('#loader').fadeOut();
                    });
                    
                    $('#display select#QuizThemeId').live('click', function(data){
                        var value2 = $('select#QuizThemeId option:selected').val();
                        
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
            var isCtrl = false;$(document).keyup(function (e) {
            if(e.which == 17) isCtrl=false;
            }).keydown(function (e) {
                if(e.which == 17) isCtrl=true;
                if(e.which == 83 && isCtrl == true) {
                    //alert('Keyboard shortcuts + JQuery are even more cool!');
                    //return false;
                    $('.submit input').click();
                    return false;
             }
            });
        });
      
<?php $this->Html->scriptEnd(); ?>

<?php echo $this->element('sidebar');  ?>
        
<div id="breadcrumbs">
	<?php echo $this->Html->link("Gérer mes quiz", array("controller" => "quiz", "action" => "manager"), array("title" => "Voir tous mes quiz"));?>
            >> Créer un nouveau quiz

</div>

<?php echo $this->Form->create('Quiz', array('url' => '/quiz/add')); ?>

   <?php echo $this->Form->input('', array('label' => "Matière :", 'type' => 'select','options' => $matieres, 
        'name'=> "data[Quiz][matiere_id]", 'id'=> 'matieres')); ?>
         
        <div id="ListeTheme" style="display:none">
            <span id="loader" style="display: none; float:left;"><?php echo $this->Html->image("loader.gif", array( "alt"=>"loading")); ?></span>
            <?php echo $this->Form->input('theme_id', array('label' => "Thème:"));?>
            
        </div>
         <div id="AjoutMatiere" style="display:none">
            <?php echo $this->Form->input('newmatiere', array("type"=> "text",'name' => "data[Matiere][name]", 'id' => 'NewMatiere',
                'label' => 'Si vous ne trouvez pas votre matière dans la liste ci-dessus, vous pouvez soumettre un nom de matière ici: '));?>
        </div>
        <div id="AjoutTheme" style="display:none">
            <?php echo $this->Form->input('newtheme', array( "type"=> "text", 'name' => "data[Theme][name]", 'id' => 'NewTheme',
                'label' => 'Si vous ne trouvez pas votre thème dans la liste ci-dessus, vous pouvez soumettre un nom de thème ici: '));?>
        </div>
         <hr />

	<?php echo $this->Form->input('name', array('label' => "Titre du quiz:"));?>
	<?php echo $this->Form->input('user_id', array('type' => "hidden", "value" => $_SESSION['Auth']['User']['id']));?>
	
	<?php echo $this->Form->input('description', array('label' => "Objectif du quiz :"));?>
	<?php //echo $this->Form->input('final_screen', array('label' => "Message à la fin du quiz :"));?>
 
<?php echo $this->Form->end('Créer ce quiz'); ?>
