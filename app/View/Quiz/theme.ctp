<div id="breadcrumbs">
	<?php echo $this->Html->link("Quiz par matières", array("controller" => "matieres", "action" => "index"), array("title" => "Voir tous les quiz"));?>
        >> <?php echo strip_tags($path['Matiere']['name']); ?>
</div>

<ul class="sommaire">

<?php foreach($themes as $theme): $theme=current($theme); ?>
    <li>
        <td><?php echo $this->Html->link($theme['name'], array('action'=> 'view', "id" => $theme['id'], "slug" => $theme['slug']));?></td>       
    </li>
<?php endforeach; ?>

</ul>