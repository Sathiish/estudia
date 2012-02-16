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
                image_explorer : '<?php echo $this->Html->url(array('controller'=>'medias','action'=>'index', "quiz", $this->request->data['Quiz']['id'])); ?>',
                image_edit : '<?php echo $this->Html->url(array('controller'=>'medias','action'=>'show')); ?>',
                relative_urls : false,
                content_css : '/css/wysiwyg.css'
        });
        
        function send_to_editor(content){
                var ed = tinyMCE.activeEditor;
                ed.execCommand('mceInsertContent',false,content); 
        }
        
        jQuery(function(){
            $('.tag a').live('click',function(){
                var e = $(this);
                $.get(e.attr('href'));
                e.parent().fadeOut();
                return false;
            })

            $('.TagTag a').live('click',function(){
                var e = $(this);
                var page = <?php echo $this->data['Quiz']['id']; ?>;
                var url = e.attr('href')+'/'+page;
                $.get(url, function(data) {
                  $('#tags').html(data);
                  $("#TagTag").attr('value', '');
                  $("#ul_TagTag").hide();
                });

                return false;
            })
            
            $('#display select#matieres').live('click', function(data){
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
            
        });
<?php $this->Html->scriptEnd(); ?>

<div id="breadcrumbs">
	<?php echo $this->Html->link("Gérer mes quiz", array("controller" => "quiz", "action" => "manager"), array("title" => "Voir tous mes quiz"));?>
            >> <?php echo $this->data['Quiz']['name']; ?>  - <a href="" onClick='$("#display").fadeIn(); return false;'>Modifier le thème</a>
</div>

<?php echo $this->Html->link('Créer une nouvelle question', array('controller' => 'questions','action'=> 'add', $this->data['Quiz']['id'], $this->data['Quiz']['slug']), array('class' => 'button')); ?>

<?php if($questions != array()): ?>
<table class="manager">
   <thead>
     <tr>
        <th class="first" style="width: 470px">Question</th>
        <th>Déplacer</th>
        <th class="last">Actions</th>
     </tr>
     </thead>
     <tbody>

     <?php $i=1; foreach($questions as $question): $question = current($question); ?>
        <tr>
             <td><?php echo $question['sort_order'].') '.strip_tags($question['question']);?></td>
             <td style="text-align: center">
                <?php echo $this->Html->image('fleche_haut.png', array(
                    "url"=> array("controller"=>"questions", "action"=>"monter", $question['id'])
                ));?> / 
                <?php echo $this->Html->image('fleche_bas.png', array(
                    "url"=> array("controller"=>"questions", "action"=>"descendre", $question['id'])
                ));?>
             </td>
             <td style="text-align: center">
            <?php echo $this->Html->link($this->Html->image('editer.png'), 
                    array("controller"=>"questions","action"=>"edit", $question['id']),
                    array("title" => "Modifier","escape" => false)); ?>
            <?php echo $this->Html->link($this->Html->image('supprimer.png'), 
                     array("controller"=>"questions", "action"=>"delete", $question['id']),
                     array("title" =>"Supprimer cette", 'escape' => false),
                     "Etes-vous certain de vouloir définitivement supprimer ce cours ?"
             );?></td>

         </tr>
     <?php endforeach; ?>
     </tbody>
 </table>
        
<?php else: ?>

<p>Vous n'avez pas encore créé de questions pour ce quiz. Cliquez sur le bouton ci-dessus pour créer votre première question.<p>

<?php endif; ?>
    
    <hr />
        
<?php echo $this->Form->create('Quiz', array('url' => '/quiz/edit/'.$this->data['Quiz']['id'])); ?>

    <div id="display" style="display:none;">
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
    </div>
	<?php echo $this->Form->input('name', array('label' => "Titre du quiz:"));?>
	
	<?php //echo $this->Form->input('user_id', array('type' => "hidden"));?>
	<?php echo $this->Form->input('id', array('type' => "hidden"));?>
	
	<?php echo $this->Form->input('description', array('label' => "Objectif du quiz :"));?>
	<?php echo $this->Form->input('final_screen', array('label' => "Correction :"));?>
        
        <hr />
    <div id="tags">
        <?php foreach($relatedTags as $tag): ?>
                <span class="etat tag">
                    <?php echo $tag['Tag']['name']; ?> 
                    <?php echo $this->Html->link("x", array("controller" => "quiztags", "action" => "delete", $tag['QuizTag']['id'])); ?> 
                </span>
        <?php endforeach; ?>
    </div>
<?php echo $this->Form->input('tags', array('label' => "Saisissez les différents niveaux concernés et cliquez dessus dès qu'ils apparaissent:", 'id' => 'TagTag'));?> 
<?php echo $this->Autocomplete->autocomplete('TagTag','Tag/name',array('TagId'=>'id')); ?>
        
        <hr />
<?php echo $this->Form->end('Enregistrer'); ?>

