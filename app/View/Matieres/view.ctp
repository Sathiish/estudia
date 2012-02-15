<div class="matieres view">
<h2><?php  echo __('Matiere');?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($matiere['Matiere']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($matiere['Matiere']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($matiere['Matiere']['description']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Matiere'), array('action' => 'edit', $matiere['Matiere']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Matiere'), array('action' => 'delete', $matiere['Matiere']['id']), null, __('Are you sure you want to delete # %s?', $matiere['Matiere']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Matieres'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Matiere'), array('action' => 'add')); ?> </li>
	</ul>
</div>
