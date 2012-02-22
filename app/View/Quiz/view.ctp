<div id="breadcrumbs">
    <?php echo $this->Html->link("Quiz par matières", array("controller" => "matieres", "action" => "index"), array("title" => "Voir tous les quiz"));?>
	>> <?php echo $this->Html->link($path['Matiere']['name'], array("controller" => "quiz", "action" => "theme", $path['Matiere']['id'], $path['Matiere']['slug']));?>
	>> <?php echo $path['Theme']['name'];?>
</div>

<table class="manager">

<?php foreach($quizz as $quiz): ?>
    <tr>
        <td style="width: 500px"><?php echo $quiz['Quiz']['name'];?></td>
        <td class="center" style="width: 150px"><span class="etat action"><?php 
        /*
         * On regarde si la personne a déjà fait ce quizz, dans ce cas on efface les anciens résultats et on recommence
         */
        $restart = ($quiz['UserAnswer'] != array())? true: false; 
        if($restart){
            echo $this->Html->link('Recommencer', array('action'=> 'start', "id" => $quiz['Quiz']['id'], "slug" => $quiz['Quiz']['slug'], "restart" => "restart"),
                    array(), "En recommançant, vous effacerez vos précédents résultats de ce quiz. Les résultats de vos autres quiz ne seront pas impactés.");
            echo '<br />'.$this->Html->link('Voir mes résultats', array('controller' => 'questions','action'=> 'resultat', $quiz['Quiz']['id'], $quiz['Quiz']['slug']));
        }else{
            echo $this->Html->link('Faire', array('action'=> 'start', "id" => $quiz['Quiz']['id'], "slug" => $quiz['Quiz']['slug'], "restart" => "go"));
        }
                
        ?></span></td>       
    </tr>

<?php endforeach; ?>

</table>


