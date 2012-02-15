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
                image_explorer : '<?php echo $this->Html->url(array('controller'=>'medias','action'=>'index',$this->data['Answer']['question_id'])); ?>',
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
            >> <?php echo $this->Html->link(strip_tags($info['Quiz']['name']), array("controller" => "quiz", "action" => "edit", $info['Quiz']['id']), array("title" => "Quiz"));?><br />
            >> <?php echo $this->Html->link(strip_tags($info['Question']['question']), array("controller" => "questions", "action" => "edit", $info['Question']['id']), array("title" => "Question")); ?>
            >> <?php echo strip_tags($this->data['Answer']['name']); ?>

</div>

<?php echo $this->Form->create('Answer'); ?>

<?php echo $this->Form->input('name', array('label' => "Votre question:", "class" => "mini"));?>
<?php echo $this->Form->input('id', array('type' => "hidden"));?>
<?php echo $this->Form->input('hint', array('label' => "Indice :", "class" => "mini"));?>
<div class="label-inline">
<?php echo $this->Form->radio(
                        'correct',
                        array('1' => 'Correcte', '0' => 'Incorrecte'),
                        array('legend'=>"Cette réponse est-elle correcte ou incorrecte ?", 'separator'=>'<br />', 'value'=>false)
                      ); ?>
</div>
 
<?php echo $this->Form->end('Mettre à jour'); ?>