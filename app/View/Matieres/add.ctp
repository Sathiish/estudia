<?php echo $this->Html->css('form'); ?>

<div class="matieres form">
<?php echo $this->Form->create('Matiere');?>
	<fieldset>
		<legend><?php echo __('Add Matiere'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('description');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Matieres'), array('action' => 'index'));?></li>
	</ul>
</div>
