<div id="breadcrumbs">
    <?php echo $this->Html->link("Quiz par matières", array("controller" => "quiz", "action" => "index"), array("title" => "Voir tous les quiz"));?>
</div>

<ul class="sommaire">
<?php foreach($matieres as $matiere): $matiere=current($matiere); ?>

            <li><?php echo $this->Html->link($matiere['titre'], array('action'=> 'theme', "id" => $matiere['id'], "slug" => $matiere['slug']));?></li>

<?php endforeach; ?>
</ul>

