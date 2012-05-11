<h3>Insérer l'image</h3>

<img src="<?php echo $src; ?>">

<?php echo $this->Form->create('Media'); ?>
	<?php echo $this->Form->input('alt',array('label'=>"Description de l'image","value"=>$alt)); ?>
<?php $hidden = (preg_match('/^http\:\/\//i', $src))?'text':'hidden'; ?>
<?php $label = ($hidden == 'text')?'URL de l\'image':''; ?>
	<?php echo $this->Form->input('src',array('type'=>$hidden,"value"=>$src, 'label' => $label)); ?>
<div class="clr"></div>
	<?php echo $this->Form->input('class',array('legend'=>"Alignement","options"=>array(
		"alignLeft" => "Aligner à gauche",
		"alignCenter" => "Aligner au centre",
		"alignRight" => "Aligner à droite"
	),'type'=>'radio','value'=>$class)); ?>
<?php echo $this->Form->end('Insérer'); ?>

