<?php echo $this->Element('menu-admin'); ?>

<div class="matieres form">
    <h1>Modifier une matière</h1>
<?php echo $this->Form->create('Matiere');?>

	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('description');
	?>

<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>

            <li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Matiere.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Matiere.id'))); ?></li>
            <li><?php echo $this->Html->link(__('List Matieres'), array('action' => 'index'));?></li>
    </ul>
</div>
