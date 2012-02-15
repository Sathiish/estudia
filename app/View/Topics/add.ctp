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
<div class="bulle information">Poser une question en <?php echo $ForumActive['Forum']['name'];?></div>
 
<?php $user_id = $_SESSION['Auth']['User']['id']; ?>
<?php echo $this->Form->create('Topic', array('controller' => 'topics', 'action' => 'add')); ?>
<?php echo $this->Form->input('id'); ?>
<?php echo $this->Form->input('name', array('label' => "Sujet :"));?>
<?php echo $this->Form->input('content', array('label' => "Ma question :"));?>
<?php echo $this->Form->input('forum_id', array('type' => "hidden", "value" => "$forum_id")); ?>
<?php echo $this->Form->input('user_id', array('type' => "hidden", "value" => "$user_id")); ?>
<?php echo $this->Form->end('Poser ma question'); ?>
     
<div class="users form"></div>
