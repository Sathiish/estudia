<?php 

if(!isset($this->params->pass[1])){
    echo "<p>Vous devez tout d'abord créer le contenu avant de pouvoir lui ajouter des images. L'ajout d'image se fera en cliquant sur cette même icône.</p>";
    die();    
} ?>

<table>
	<tr>
		<th class="first">Image</th>
		<th>Nom</th>
		<th class="last">Actions</th>
	</tr>
	<?php foreach ($medias as $k => $v): $v = current($v); ?>
	<tr>
		<td><?php echo $this->Html->image($v['url'],array('style'=>'max-width:200px')); ?></td>
		<td><?php echo $v['name']; ?></td>
		<td>
			<?php foreach($formats as $kk=>$vv): ?>
				<?php echo $this->Html->link("Image ".$vv."px",array('action'=>'show',$v['id'],$kk)); ?> <br>
			<?php endforeach; ?>
			<?php echo $this->Html->link("Image originale",array('action'=>'show',$v['id'])); ?> <br>
			<?php echo $this->Html->link("Supprimer",array('action'=>'delete',$v['id']),null,'Voulez vraiment supprimer l\'image'); ?>
		</td>
	</tr>
	<?php endforeach ?>
</table>


<h3>Ajouter une image</h3>

<?php echo $this->Form->create('Media',array('type'=>'file')); ?>
	<?php echo $this->Form->input('file',array('label'=>"Image (format png/jpg)","type"=>"file")); ?>
	<?php echo $this->Form->input('name',array('label'=>"Nom de l'image")); ?>
<?php echo $this->Form->end('Ajouter'); ?>

<div class="clr"></div>

<h3>Depuis le web</h3>

<?php echo $this->Form->create('Media'); ?>
	<?php echo $this->Form->input('url',array('label'=>"URL de l'image")); ?>
<?php echo $this->Form->end('Insérer'); ?>