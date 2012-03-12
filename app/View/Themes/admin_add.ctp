<?php echo $this->Element('menu-admin'); ?>

<h1>Créer un nouveau thème</h1>

<?php echo $this->Form->create('Theme'); ?>
<?php echo $this->Form->input('classe_id'); ?>
<?php echo $this->Form->input('matiere_id'); ?>
<?php echo $this->Form->input('name'); ?>
<?php echo $this->Form->input('published'); ?>
<?php echo $this->Form->end('Enregistrer'); ?>
