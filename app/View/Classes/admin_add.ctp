<?php echo $this->Element('menu-admin'); ?>

    <h1>Ajouter une classe</h1>

<?php 
echo $this->Form->create('Classe');
echo $this->Form->input('name');
echo $this->Form->end('Enregistrer');?>


<h3><?php echo $this->Html->link('Liste des classes', array('action' => 'index'));?></h3>

