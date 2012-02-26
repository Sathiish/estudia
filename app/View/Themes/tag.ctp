<div id="breadcrumbs">
	Les cours par classe
            >> <?php echo $this->Html->link(strip_tags($tag['name']), array("controller" => "matieres", "action" => "tag", $tag['id'], $tag['slug']));?><br />
            >> <?php echo $this->Html->link(strip_tags($matiere['Matiere']['name']), array("controller" => "matieres", "action" => "tag", $tag['id'], $matiere['Matiere']['id'], $tag['slug']));?>
            >> Choississez votre thème

</div>

<ul class="sommaire">
    <?php foreach($themes as $theme): ?>
    <li><?php echo $this->Html->link($theme['Theme']['name'].' ('.$theme['Theme']['count_published_cours'].')', array(
        "controller" => "cours", 
        "action" => "tag", 
        $theme['CourTag']['tag_id'],
        $theme['Theme']['id'],
        $theme['Tag']['slug']
        )); ?></li>
    <?php endforeach; ?>
</ul>