<?php echo $this->Html->css('form', null, array('inline' => false));?>


<h1>Créer/modifier une catégorie</h1>

<?php echo $this->Form->create('Forum', array('controller' => 'forums', 'action' => 'add_category')); ?>
<?php echo $this->Form->input('id'); ?>
<?php echo $this->Form->input('name', array('label' => "Titre:"));?>
<?php echo $this->Form->end('Enregistrer cette catégorie'); ?>
     
<div class="users form"></div>
