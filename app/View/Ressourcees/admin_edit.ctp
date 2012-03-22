<?php $this->Html->script('tiny_mce/tiny_mce.js',array('inline'=>false)); ?>
<?php echo $this->Html->css('form', null, array('inline' => false));?>
<script type="text/javascript">
//<![CDATA[
        
        tinyMCE.init({
                mode : 'textareas',
                theme: 'advanced',               
                plugins: 'inlinepopups,paste,emotions',
                entity_encoding : "raw",
                height : "510",
                
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

<h1>Créer/modifier une matière</h1>

<div class="filAriane">
    <?php echo $this->Html->link('Ressource', array("action"=> 'index')); ?>  
    <?php foreach($parents as $parent): $parent = current($parent); ?>
           >> <?php echo $this->Html->link($parent['titre'], array("action"=> 'view', $parent['id'], $parent['slug'])); ?>  
    <?php endforeach; ?>           
</div>

<?php (empty($this->data['Ressource']['id']) || $this->data['Ressource']['parent_id'] == "0")? $type = "matiere": $type = "theme";?>
<?php (empty($this->data['Ressource']['parent_id']))? $parent_id = "0": $parent_id = $this->data['Ressource']['parent_id'];?>


<?php echo $this->Form->create('Ressource', array('controller' => 'ressources', 'action' => 'add')); ?>
<?php echo $this->Form->input('id'); ?>
<?php echo $this->Form->input('type', array('type' => "hidden", 'value' => "$type")); ?>
<?php echo $this->Form->input('parent_id', array('type' => "hidden", 'value' => "$parent_id")); ?>
<?php echo $this->Form->input('titre', array('label' => "Titre de la matière:"));?>
<?php echo $this->Form->input('contenu', array('label' => "Résumé :"));?>
Publié : <?php echo $this->Form->input('etat', array('label' => ""));?>
<?php echo $this->Form->end('Enregistrer cette matière'); ?>
     
<div class="users form"></div>