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
                image_explorer : '<?php echo $this->Html->url(array('controller'=>'medias','action'=>'index', 'quiz', $this->data['Quiz']['id'])); ?>',
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
	<?php echo $this->Html->link("Gérer mes quiz", array("controller" => "quiz", "action" => "manager"), array("title" => "Voir tous mes quiz"));?>
            >> <?php echo $this->Html->link(strip_tags($this->data['Quiz']['name']), array("controller" => "questions", "action" => "manager", $this->data['Quiz']['id']), array("title" => "Quiz"));?><br />
            >> <?php echo strip_tags($this->data['Question']['question']); ?>
</div>

<?php echo $this->Html->link('Créer une nouvelle réponse', array('controller' => 'answers', 'action'=> 'add', $this->data['Question']['id']), array('class' => 'button')); ?>

<h2><?php echo $this->data['Question']['question']; ?></h2>

<?php if($answers != array()): ?>
<table class="manager">
   <thead>
     <tr>
        <th class="first" style="width: 470px">Réponse</th>
        <th style="width:70px">Correcte</th>
        <th style="width:40px">Déplacer</th>
        <th class="last" style="width:30px">Actions</th>
     </tr>
     </thead>
     <tbody>
     <?php $i=1; foreach($answers as $answer): $answer = current($answer); ?>
        <tr>
            <td><?php echo $answer['sort_order'].') '.strip_tags($answer['name']);?></td>
             
             <td style="text-align: center"><?php ($answer['correct'] == 1)? $result= '<span class="etat publie">Correcte</span>': $result = '<span class="etat non_publie">Incorrecte</span>'; echo $result; ?></td>
             <td style="text-align: center">
                <?php echo $this->Html->image('fleche_haut.png', array(
                    "url"=> array('controller' => 'answers', "action"=>"monter", $answer['id'])
                ));?> / 
                <?php echo $this->Html->image('fleche_bas.png', array(
                    "url"=> array('controller' => 'answers', "action"=>"descendre", $answer['id'])
                ));?>
             </td>
             <td style="text-align: center">
             <?php echo $this->Html->link($this->Html->image('editer.png'), array('controller' => 'answers', "action"=>"edit", $answer['id']),array("escape" => false,'title' => 'Editer')); ?>
             
            <?php echo $this->Html->link($this->Html->image('supprimer.png'), 
                     array('controller' => 'answers', "action"=>"delete", $answer['id']),
                     array("title" =>"Supprimer cette", 'escape' => false),
                     "Etes-vous certain de vouloir définitivement supprimer ce cours ?"
             );?></td>

         </tr>
     <?php endforeach; ?>
     </tbody>
 </table>

<?php else: ?>

<p>Vous n'avez pas encore créé de réponse à cette question. Cliquez sur le bouton ci-dessus pour créer votre première réponse.<p>

<?php endif; ?>
    <hr />
    
<?php echo $this->Form->create('Question', array('action' => 'edit')); ?>
    <?php echo $this->Form->input('question', array('label' => "Votre question:"));?>
    <?php echo $this->Form->input('user_id', array('type' => "hidden"));?>
    <?php echo $this->Form->input('id', array('type' => "hidden"));?>	
    <?php echo $this->Form->input('explanation', array('label' => "Explication :"));?>
<?php echo $this->Form->end('Enregistrer'); ?>