<div id="breadcrumbs">
	Les cours par classe
            >> <?php echo $this->Html->link(strip_tags($tag['Tag']['name']), array("controller" => "matieres", "action" => "tag", $tag['Tag']['id'], $tag['Tag']['slug']));?><br />
            >> <?php echo $this->Html->link(strip_tags($theme['Matiere']['name']), array("controller" => "themes", "action" => "tag", $tag['Tag']['id'], $theme['Matiere']['id'], $tag['Tag']['slug']));?>
            >> <?php echo $theme['Theme']['name'];?>
            >> Choississez votre cours

</div>

<ul class="sommaire">

<?php foreach ($cours as $c): ?>
    <li><?php echo $this->Html->link($c['Cour']['name'], 
            array(
                "controller" => "cours", 
                "action" => "show", 
                $c['Cour']['id'], 
                $c['Cour']['slug']
                )); ?></li>
<?php endforeach; ?>

</ul>