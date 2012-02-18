<?php echo $this->Html->css('form', null, array('inline' => false));?>
<?php $this->Html->script('tiny_mce/tiny_mce.js',array('inline'=>false)); ?>
<?php $result = (isset($this->params->pass[1]))? "index": "message";?>
<?php $this->Html->scriptStart(array('inline'=>false)); ?>
        tinyMCE.init({
                mode : 'textareas',
                theme: 'advanced',               
                plugins: 'inlinepopups,paste,emotions,image',
                entity_encoding : "raw",
                
                theme_advanced_buttons1 : 'bold,italic,underline,|,bullist,numlist,|,justifyleft,justifycenter,justifyright,justifyfull,|,link,unlink,|,emotions, image',
                theme_advanced_buttons2 : '',
                theme_advanced_buttons3 : '',
                theme_advanced_buttons4 : '',
                theme_advanced_toolbar_location:'top',
                theme_advanced_statusbar_location : 'bottom',
                theme_advanced_resizing : true,
                width : '675',
                height : '400',
                paste_remove_styles : true,
                paste_remove_spans :  true,
                paste_stip_class_attributes : "all",
                image_explorer : '<?php echo $this->Html->url(array('controller'=>'medias','action'=>$result, "cours", $this->request->data['Cour']['id'])); ?>',
                image_edit : '<?php echo $this->Html->url(array('controller'=>'medias','action'=>'show')); ?>',
                relative_urls : false,
                content_css : '/css/wysiwyg.css'
        });
        
        function send_to_editor(content){
                var ed = tinyMCE.activeEditor;
                ed.execCommand('mceInsertContent',false,content); 
        }
        
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
                      $('#CourThemeId').html(data);
                      $('#loader').fadeOut();
                    });
                    
                    $('#display select#CourThemeId').live('click', function(data){
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
            
        <?php if(isset($this->data['Cour']['id'])): ?>
        jQuery(function(){
            $('.tag a').live('click',function(){
                var e = $(this);
                $.get(e.attr('href'));
                e.parent().fadeOut();
                return false;
            })

            $('.TagTag a').live('click',function(){
                var e = $(this);
                var page = <?php echo $this->data['Cour']['id']; ?>;
                var url = e.attr('href')+'/'+page;
                $.get(url, function(data) {
                  $('#tags').html(data);
                  $("#TagTag").attr('value', '');
                  $("#ul_TagTag").hide();
                });

                return false;
            })
            
        });
        <?php endif; ?>
        
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

<?php $this->Html->scriptEnd(); ?>

<?php echo $this->Form->create('Cour', array('controller' => 'cours', 'action' => 'edit')); ?>

<?php $display = ""; ?>
<?php if(isset($this->data['Theme'])): ?>
<div id="breadcrumbs">
        <?php echo $this->Html->link('Mes cours', array("controller" => "cours", "action" => "manager")); ?>
        >> <?php echo $this->data['Theme']['Matiere']['name']; ?> 
        >> <?php echo $this->data['Theme']['name']; ?> - <a href="" onClick='$("#display").show(); return false;'>Modifier</a>
        <?php $display = "display:none"; ?>
</div>
        
<div id="onglets_tutos" class="onglets_tutos">
  <ul>
      <li>
      <?php echo $this->Html->link('Tutoriel hors ligne',array("controller" => "cours", "action" => "visualiser", $this->data['Cour']['id'], $this->data['Cour']['slug'])); ?></li>
      <li class="selected">
      <?php echo $this->Html->link('Edition',array("controller" => "cours", "action" => "edit", $this->data['Cour']['id'], $this->data['Cour']['slug'])); ?></li>
  </ul>
</div>
        
        <?php echo $this->Html->link('Ajouter une partie', array('controller' => 'parties', 'action'=> 'add', $this->data['Cour']['id'], $this->data['Cour']['slug']), array('class' => 'button')); ?>

<?php if($parties != array()): ?>

<table class="manager">
   <thead>
     <tr>
        <th class="first" style="width: 490px">Cours</th>
        <th>Déplacer</th>
        <th class="last" style="width:100px;">Actions</th>
     </tr>
     </thead>
     <tbody>
     <?php foreach($parties as $cours_info): $c = current($cours_info); ?>
        <tr>
             <td><?php echo $this->Html->link($c['sort_order'].') '.$c['name'], array("controller" => "parties", "action" => "visualiser", $c['id'], $c['slug']));?><br />

             <?php if($c['validation']){
                    if($c['public']){
                        echo '<span class="etat en_attente">En attente de dépublication</span>';
                    }
                    else{
                        echo '<span class="etat en_attente">En attente de publication</span>';
                    }
                }else{
                    if($c['public']){
                        echo '<span class="etat publie">Publié</span>';
                    }
                    else{
                        echo '<span class="etat non_publie">Non-publié</span>';
                    }                    
               
                }
                ?></td>
              <td style="vertical-align: middle;">
                <?php echo $this->Html->image('fleche_haut.png', array(
                    "url"=> array("controller" => "parties", "action"=>"monter", $c['id'])
                ));?> / 
                <?php echo $this->Html->image('fleche_bas.png', array(
                    "url"=> array("controller" => "parties", "action"=>"descendre", $c['id'])
                ));?>
             </td>
             <td style="vertical-align: middle;">
             <?php if(!($c['public']) AND !($c['validation'])): ?>    
             <?php echo $this->Html->link($this->Html->image('editer.png'), array("controller" => "parties", "action"=>"edit", $c['id'], $c['slug']),array("escape" => false)); ?>
             <?php echo $this->Html->link($this->Html->image('supprimer.png'), 
                     array("controller" => "parties", "action"=>"delete", $c['id']),
                     array("title" =>"Supprimer cette", 'escape' => false),
                     "Etes-vous certain de vouloir définitivement supprimer ce cours ?"
             );?>
             <?php endif; ?>
             <?php 
             
             if(!$c['validation']){
                 if($c['public']){
                    echo $this->Html->link('<span class="etat action">Dépublier</span>', 
                         array("action"=>"askforunreleased", $c['id']),
                         array("title" =>"Demander la publication de ce quizz", 'escape' => false),
                         "Une fois dépublié, ce quiz n'apparaitra plus en ligne. Vous pourrez toutefois demander sa publication à nouveau. Souhaitez-vous toujours demander sa dépublication dès maintenant ?"
                    );
                 }else{
                    echo $this->Html->link('<span class="etat action">Publier</span>', 
                         array("action"=>"askforreleased", $c['id']),
                         array("title" =>"Demander la publication de ce quizz", 'escape' => false),
                         "Une fois publié, pour modifier ce quiz, vous devrez d'abord demander sa dépublication. Souhaitez-vous toujours demander la publication dès maintenant ?"
                    );  
                 }
                 
             
             }
             ?></td>
         </tr>
     <?php endforeach; ?>
     </tbody>
 </table>

<?php else: ?>
    <p>Vous n'avez ajouté aucunes parties à ce cours pour le moment. Cliquez ci-dessus pour créer des parties.</p>
<?php endif; ?>
        
<?php endif; ?>
        
<div id="display" style="<?php echo $display; ?>">

    <?php echo $this->Form->input('', array('label' => "Matière :", 'type' => 'select','options' => $matieres, 
        'name'=> "data[Cour][matiere_id]", 'id'=> 'matieres')); ?>
     
    
    <div id="AjoutMatiere" style="display:none">
        <?php echo $this->Form->input('newmatiere', array("type"=> "text",'name' => "data[Matiere][name]", 'id' => 'NewMatiere',
            'label' => 'Si vous ne trouvez pas votre matière dans la liste ci-dessus, vous pouvez soumettre un nom de matière ici: '));?>
        
    </div>
    
    <div id="ListeTheme" style="display:none">
	<select name="data[Cour][theme_id]" id="CourThemeId"></select>
        <span id="loader" style="display: none; float:left;"><?php echo $this->Html->image("loader.gif", array( "alt"=>"loading")); ?></span>
    </div>
    
    <div id="AjoutTheme" style="display:none">
        <?php echo $this->Form->input('newtheme', array( "type"=> "text", 'name' => "data[Theme][name]",'id' => 'NewTheme',
            'label' => 'Si vous ne trouvez pas votre thème dans la liste ci-dessus, vous pouvez soumettre un nom de thème ici: '));?>
    </div>
</div> 
        <hr />

<?php echo $this->Form->input('name', array('label' => "Titre du cours:"));?>
<?php echo $this->Form->input('contenu', array('label' => "Vous pouvez saisir l'introduction de ce cours ici :"));?>
       
<?php echo $this->Form->end('Enregistrer'); ?>

                
        <?php if(isset($this->data['Cour']['id'])): ?>
        <hr />
<div class="tagspace"
    <div id="tags">
        <?php foreach($relatedTags as $tag): ?>
                <span class="etat tag">
                    <?php echo $tag['Tag']['name']; ?> 
                    <?php echo $this->Html->link("x", array("controller" => "courtags", "action" => "delete", $tag['CourTag']['id'])); ?> 
                </span>
        <?php endforeach; ?>
    </div>
<?php echo $this->Form->input('tags', array('label' => "Classes:", 'id' => 'TagTag'));?> 
<?php echo $this->Autocomplete->autocomplete('TagTag','Tag/name',array('TagId'=>'id')); ?>
</div>
        <?php endif; ?>