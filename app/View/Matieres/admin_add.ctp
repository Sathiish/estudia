<?php echo $this->Html->css('form'); ?>

<?php echo $this->Element('menu-admin'); ?>

    <h1>Ajouter une matière</h1>
    
<div class="matieres form">
<?php echo $this->Form->create('Matiere');?>

	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('description');
	?>
	</fieldset>
<?php echo $this->Form->end('Enregistrer');?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Matieres'), array('action' => 'index'));?></li>
	</ul>
</div>
