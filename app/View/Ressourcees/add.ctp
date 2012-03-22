<?php echo $this->Html->css('form', null, array('inline' => false));?>
<?php $this->Html->script('tiny_mce/tiny_mce.js',array('inline'=>false)); ?>
<?php $this->Html->scriptStart(array('inline'=>false)); ?>
        
        tinyMCE.init({
                mode : 'textareas',
                theme: 'advanced',               
                plugins: 'inlinepopups,paste,emotions',
                entity_encoding : "raw",
                
                theme_advanced_buttons1 : 'bold,italic,underline,|,bullist,numlist,|,justifyleft,justifycenter,justifyright,justifyfull,|,link,unlink,|,emotions',
                theme_advanced_buttons2 : '',
                theme_advanced_buttons3 : '',
                theme_advanced_buttons4 : '',
                theme_advanced_toolbar_location:'top',
                theme_advanced_statusbar_location : 'bottom',
                theme_advanced_resizing : true,
                paste_remove_styles : true,
                paste_remove_spans :  true,
                paste_stip_class_attributes : "all",
                relative_urls : false,
                content_css : '<?php echo $this->Html->url('/css/wysiwyg.css'); ?>'
        });

<?php $this->Html->scriptEnd(); ?>

<?php echo $this->Form->create('Ressource', array('action' => 'add')); ?>
<?php echo $this->Form->input('parent_id', array('type' => "hidden", 'value' => $parent['Ressource']['id'])); ?>
<?php echo $this->Form->input('user_id', array('type' => "hidden", 'value' => $_SESSION['Auth']['User']['id'])); ?>
<?php echo $this->Form->input('type', array('type' => "hidden", 'value' => $childrenType)); ?>
<?php echo $this->Form->input('titre', array('label' => "Titre de la partie:"));?>
<?php echo $this->Form->input('contenu', array('label' => "Saississez le contenu ici :"));?>
<?php echo $this->Form->end('Enregistrer cette partie'); ?>
        
