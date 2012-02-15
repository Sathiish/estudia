<div id="breadcrumbs">
    <?php echo $this->Html->link("Quiz par matières", array("controller" => "quiz", "action" => "index"), array("title" => "Voir tous les quiz"));?>
    <?php foreach($path as $p): ?>
 <?php ($p['Ressource']['type'] == "matiere")? $cible = "theme": $cible = "view"; ?>
	>> <?php echo $this->Html->link($p['Ressource']['titre'], array("controller" => "quiz", "action" => $cible, "id" => $p['Ressource']['id'], "slug" => $p['Ressource']['slug']), array("title" => "Voir tous mes quiz"));?>
    <?php endforeach; ?>
</div>

<table>

<?php foreach($quizz as $quiz):
    /*
     * On regarde si la personne a déjà fait ce quizz, dans ce cas on efface les anciens résultats et on recommence
     */
     $restart = ($quiz['UserAnswer'] != array())? true: false; 
     
?>
    <tr>
        <td><?php echo $quiz['Quiz']['name'];?></td>
        <td style="width: 150px"><span class="etat action"><?php 
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


