<div id="breadcrumbs">
	<?php echo $this->Html->link('Les cours par classe', array("controller" => "tags", "action" => "index")); ?>
            >> <?php echo strip_tags($tag['Tag']['name']);?><br />
            >> Choississez une matiere
</div>

<ul class="sommaire">

<?php foreach ($matieres as $matiere): ?>
    <li><?php echo $this->Html->link($matiere['Matiere']['name'], 
            array(
                "controller" => "themes", 
                "action" => "tag", 
                $matiere['Tag']['id'],
                $matiere['Matiere']['id'],
                $matiere['Tag']['slug']
                )); ?></li>
<?php endforeach; ?>

</ul>