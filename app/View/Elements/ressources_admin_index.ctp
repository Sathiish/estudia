<?php $id = $data['Ressource']['id']; ?>

<h1><?php echo $data['Ressource']['titre']; ?></h1>
<ul class="options">
	<li><?php echo $this->Html->link('Monter', 'move_up/'.$id); ?></li>
	<li><?php echo $this->Html->link('Descendre', 'move_down/'.$id); ?></li>
	<li><?php echo $this->Html->link("Modifier", 'edit/'.$id); ?></li>
	<li><?php echo $this->Html->link("Supprimer", 'delete/'.$id,null, "Etes-vous certain de vouloir supprimer cette ressource ?"); ?></li>
</ul>