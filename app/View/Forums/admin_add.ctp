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

<h1>Créer/modifier un Forum</h1>
<?php $category_id = $this->params->pass[0]; ?>
<?php echo $this->Form->create('Forum', array('controller' => 'forums', 'action' => 'admin_add')); ?>
<?php echo $this->Form->input('id'); ?>
<?php echo $this->Form->input('category_id', array('type' => "hidden", "value" => "$category_id")); ?>
<?php echo $this->Form->input('name', array('label' => "Titre du forum:"));?>
<?php echo $this->Form->input('description', array('label' => "Description :"));?>
<?php echo $this->Form->end('Enregistrer ce forum'); ?>
     
<div class="users form"></div>
