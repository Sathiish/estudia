<?php echo $this->Html->css('form', null, array('inline'=>false)); ?>
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
                height : '400',
                forced_root_block : false,
                force_br_newlines : true,
                force_p_newlines : false,
                paste_remove_styles : true,
                paste_remove_spans :  true,
                paste_stip_class_attributes : "all",
                image_explorer : '<?php echo $this->Html->url(array('controller'=>'medias','action'=>'index', "cours", $path['Cour']['id'])); ?>',
                image_edit : '<?php echo $this->Html->url(array('controller'=>'medias','action'=>'show')); ?>',
                relative_urls : false,
                content_css : '/css/wysiwyg.css'
        });
        
        function send_to_editor(content){
                var ed = tinyMCE.activeEditor;
                ed.execCommand('mceInsertContent',false,content); 
        }
<?php $this->Html->scriptEnd(); ?>

<div id="breadcrumbs">
	<?php echo $this->Html->link("Mes cours", array("controller" => "cours", "action" => "manager"), array("title" => "Voir tous mes cours"));?>
            >> <?php echo $this->Html->link($path['Cour']['name'], array("controller" => "cours", "action" => "edit", $path['Cour']['id'], $path['Cour']['slug']), array("title" => "Voir tous mes cours"));?>
            >> <?php echo $path['Partie']['name']; ?>
</div>

<div id="onglets_tutos" class="onglets_tutos">
  <ul>
    
      <li>
      <?php echo $this->Html->link('Tutoriel hors ligne',array("controller" => "parties", "action" => "visualiser", $path['Partie']['id'], $path['Partie']['slug'])); ?></li>
    
      <li class="selected">
      <?php echo $this->Html->link('Edition',array("controller" => "parties", "action" => "edit", $path['Partie']['id'], $path['Partie']['slug'])); ?></li>
    
  </ul>
</div>
     
<?php echo $this->Html->link('Ajouter une sous-partie', array('controller' => 'sousparties', 'action'=> 'add', $path['Partie']['id'], $path['Partie']['slug']), array('class' => 'button')); ?>

        <?php if($sousParties != array()): ?>

<table class="manager">
   <thead>
     <tr>
        <th class="first" style="text-align: center">Sous-parties</th>
        <th style="text-align: center; width:40px">Déplacer</th>
        <th class="last" style="text-align: center; width:210px">Actions</th>
     </tr>
     </thead>
     <tbody>
     <?php foreach($sousParties as $cours_info): $c = current($cours_info); ?>
        <tr>
             <td><?php echo $c['sort_order'].') '.$c['name'];?><br />

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
             <td style="text-align: center">
                <?php echo $this->Html->image('fleche_haut.png', array(
                    "url"=> array("controller" => "sousparties", "action"=>"monter", $c['id']),
                    "title" => "Remonter cette sous-partie"
                ));?> /
                <?php echo $this->Html->image('fleche_bas.png', array(
                    "url" => array("controller" => "sousparties", "action"=>"descendre", $c['id']),
                    "title" => "Descendre cette sous-partie"
                ));?>
             </td>
             <td style="text-align: left;">
             <?php if(!($c['public']) AND !($c['validation'])): ?>    
             <?php echo $this->Html->link('<span class="etat action">'.$this->Html->image('editer.png').' Modifier</span>', array("controller" => "sousparties", "action"=>"edit", $c['id'], $c['slug']),array("escape" => false)); ?>
             <?php echo $this->Html->link('<span class="etat action">'.$this->Html->image('supprimer.png').' Supprimer</span>', 
                     array("action"=>"delete", $c['id']),
                     array("title" =>"Supprimer cette sous-partie", 'escape' => false),
                     "Etes-vous certain de vouloir définitivement supprimer cette sous-partie ?"
             );?><br />            
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
    <p>Vous n'avez ajouté aucunes sous-parties à ce cours pour le moment. Cliquez ci-dessus pour créer des sous-parties.</p>
<?php endif; ?>
    
    <hr />
    
<?php 
        echo $this->Form->create('Partie', array('controller' => 'parties', 'action' => "edit", $this->data['Partie']['id']));
        echo $this->Form->input('id');
        echo $this->Form->input('name', array('label' => 'Titre de la partie :'));
        echo $this->Form->input('contenu', array('label' => 'Introduction :'));
        echo $this->Form->end('Enregistrer');
?>
