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
                image_explorer : '<?php echo $this->Html->url(array('controller'=>'medias','action'=>'index', "quiz", $info['Quiz']['id'])); ?>',
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
            >> <?php echo $this->Html->link(strip_tags($info['Quiz']['name']), array("controller" => "questions", "action" => "manager", $info['Quiz']['id']), array("title" => "Quiz"));?><br />
            >> Créer une nouvelle question

</div>

<p>Vous êtes sur le point d'ajouter une nouvelle question à votre quiz. <br />Pour chaque nouvelle question de votre quiz remplissez le formulaire ci-dessous. </p>

<?php echo $this->Form->create('Question', array("controller"=> "questions",'action' => 'add')); ?>
<?php echo $this->Form->input('question', array('label' => "Votre question:"));?>
<?php echo $this->Form->input('user_id', array('type' => "hidden", "value" => $_SESSION['Auth']['User']['id']));?>
<?php echo $this->Form->input('quiz_id', array('type' => "hidden", "value" => $quizId));?>
<?php echo $this->Form->input('explanation', array('label' => "Explication :"));?>
<?php echo $this->Form->end('Créer cette question'); ?>