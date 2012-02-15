<?php echo $this->Html->css('form', null, array('inline' => false));?>

<script type="text/javascript">
//<![CDATA[
        
        tinyMCE.init({
                mode : 'textareas',
                theme: 'advanced',               
                plugins: 'inlinepopups,paste,emotions',
                entity_encoding : "raw",
                
                theme_advanced_buttons1 : 'bold,italic,underline,|,bullist,numlist,|,justifyleft,justifycenter,justifyright,justifyfull,|,link,unlink',
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
                content_css : '/css/wysiwyg.css'
        });


//]]>
</script>

<h1>Modifier un post</h1>

<?php echo $this->Form->create('Post', array('controller' => 'posts', 'action' => 'admin_edit')); ?>
<?php echo $this->Form->input('id'); ?>
<?php echo $this->Form->input('content', array('label' => "Contenu :"));?>
<?php echo $this->Form->input('topic_id', array('type' => "hidden")); ?>
<?php echo $this->Form->end('Modifier ce post'); ?>
     
<div class="users form"></div>
