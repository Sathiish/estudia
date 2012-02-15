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
                image_explorer : '<?php echo $this->Html->url(array('controller'=>'medias','action'=>'index', 'cours', $path['Cour']['id'])); ?>',
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
            >> <?php echo $this->Html->link($path['Cour']['name'], array("controller" => "cours", "action" => "show", $path['Cour']['id'], $path['Cour']['slug']), array("title" => "Voir tous mes cours"));?>
            <br />>> Ajouter une partie

</div>

<?php 
        echo $this->Form->create('Partie', array('url' => "add/".$path['Cour']['id']));
        echo $this->Form->input('name', array('label' => 'Titre de la partie :'));
        echo $this->Form->input('contenu', array('label' => 'Introduction :'));
        echo $this->Form->end('Enregistrer');
?>
