<?php echo $this->Html->css('form'); ?>
<script>
        tinyMCE.init({
                mode : 'textareas',
                theme: 'advanced',
                editor_deselector : "mceNoEditor",
                plugins: 'inlinepopups,paste,emotions,image, fullscreen',
                entity_encoding : "raw",
                
                theme_advanced_buttons1 : 'bold,italic,underline,|,bullist,numlist,|,justifyleft,justifycenter,justifyright,justifyfull,|,link,unlink,|,emotions, image,|, fullscreen',
                theme_advanced_buttons2 : '',
                theme_advanced_buttons3 : '',
                theme_advanced_buttons4 : '',
                theme_advanced_toolbar_location:'top',
                theme_advanced_statusbar_location : 'bottom',
                theme_advanced_resizing : true,
                width : '610',
                height : '400',
                forced_root_block : false,
                force_br_newlines : true,
                force_p_newlines : false,
                paste_remove_styles : true,
                paste_remove_spans :  true,
                paste_stip_class_attributes : "all",
                image_explorer : '<?php echo $this->Html->url(array('controller'=>'medias','action'=>'index', "cours", $path['Partie']['Cour']['id'])); ?>',
                image_edit : '<?php echo $this->Html->url(array('controller'=>'medias','action'=>'show')); ?>',
                relative_urls : false,
                content_css : '/css/wysiwyg.css'
        });
        
        function send_to_editor(content){
                var ed = tinyMCE.activeEditor;
                ed.execCommand('mceInsertContent',false,content); 
        }
</script>
      
 <div id="cours-edit" class="content-bloc">
        <h3>Modifier une sous-partie</h3>
        <div class="inside">
<?php
        echo $this->Form->create('SousPartie', array('url' => "edit/"));
        echo $this->Form->input('id');
        echo $this->Form->input('name', array('label' => 'Titre de la partie :', 'style' => 'width:590px'));
        echo $this->Form->input('contenu', array('label' => 'Introduction :'));
?>
        <a href="" onClick="$(this).parent().parent().parent().slideUp(); return false;" class="modifier">Annuler</a>
<?php echo $this->Form->end('Enregistrer'); ?>
<div class="clr"></div>
        </div>