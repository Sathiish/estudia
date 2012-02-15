<div id="breadcrumbs">
	<?php echo $this->Html->link("Quiz par matière", array("controller" => "quiz", "action" => "index"), array("title" => "Voir tous les quiz par matière"));?>
        >> <?php echo strip_tags($path['Ressource']['titre']); ?>
</div>

<ul class="sommaire">

<?php foreach($themes as $theme): $theme=current($theme); ?>
    <li>
        <td><?php echo $this->Html->link($theme['titre'], array('action'=> 'view', "id" => $theme['id'], "slug" => $theme['slug']));?></td>       
    </li>

<?php endforeach; ?>

</ul>