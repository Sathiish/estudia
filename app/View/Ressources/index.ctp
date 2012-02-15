<?php $this->set('title_for_layout', "Matières"); ?>
<?php echo $this->Html->css('ressource', null, array('inline' => false));?>
 
     <div class="titre"><?php echo $this->Html->image('titre/titre_ressources.png', array('alt' => 'Titre dashboard','width'=>'254', 'height'=>'28')); ?></div>
    
<!--    <fieldset>
    <legend>Rechercher un cours</legend>
    
    <?php echo $this->Form->Create('Ressource'); ?>
    <?php echo $this->Form->input('titre', array("label" => "Votre recherche :")); ?>
    <?php echo $this->Form->input('Matière', array("label" => "Dans :", "type"=>"select", "options"=> $matieres)); ?>
    <?php echo $this->Form->input('Classe', array("label" => "Niveau :", "type"=>"select","options"=> array(
            "Terminale",
            "Premiere",
            "Seconde"))); ?>
    <?php echo $this->Form->end('Rechercher'); ?>
</fieldset>--><br />
    
    <?php foreach($matieres as $matiere): $matiere = current($matiere); ?>

        <div class="partie">
            <div class="vignette">
                <div class="vignette <?php echo $matiere['slug']; ?>"><?php echo $this->Html->link('', array('action'=> 'view', "id" => $matiere['id'], "slug" => $matiere['slug']));?></div>
                <img class="bottom" src="/img/cours/bottom_matiere.png" />
            </div>
            <span class="partie title"><?php echo $this->Html->link($matiere['titre'], array('action'=> 'view', "id" => $matiere['id'], "slug" => $matiere['slug']));?></span>
        </div>
    <?php endforeach; ?>



