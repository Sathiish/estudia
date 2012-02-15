<?php date_default_timezone_set('Europe/Budapest'); ?>
    
    <div id="breadcrumbs">
    <?php echo $this->Html->link("Quiz par matières", array("controller" => "quiz", "action" => "index"), array("title" => "Voir tous les quiz"));?>
            >> <?php echo $this->Html->link(strip_tags($quiz_info['Ressource']['titre']), 
                    array("controller" => "quiz", "action" => "view", "id" => $quiz_info['Ressource']['id'], "slug" => $quiz_info['Ressource']['slug']), 
                    array("title" => "Voir tous les quiz de ce thème"));?><br />
            >> Mes résultats: <?php echo strip_tags($quiz_info['name']);?>
</div>

<table>

    <?php $i = 2; foreach ($reponses as $reponse):
        
        $reponse['answer_id'] = $_SESSION["QuizAnswers-$i"]['answer_id'];
        $reponse['time'] = gmdate("H:i:s", $_SESSION["QuizAnswers-$i"]['time']);

        /*
         * On vérifie si la réponse est bonne, et on affiche le bon résultat
         */

        if($reponse['Answer'][0]['id'] == $reponse['answer_id']){
            $resultat = "Réussi";
            $class = "publie";
        }else{
            $resultat = "Echec";
            $class = "non_publie";
        }
       
    ?>
    <tr>
        <td><?php echo strip_tags($reponse['Question']['question'],'<a><br />'); ?></td>
        <td style="text-align:center; width:80px"><?php echo $reponse['time']; ?></td>
        <td style="text-align:center; width:80px"><?php echo $this->Html->link('<span class="etat '.$class.'">'.$resultat.'</span>', 
                array('controller'=>'questions', 'action'=> 'explication', $reponse['Question']['id']),
                array('escape' => false, 'title' => 'Voir la correction')
                ); ?></td>
    </tr>
    
    <?php $i++; endforeach; ?>
    
</table>

<p>Pour continuer à vous exercer sur ZeSchool et profiter des nombreuses autres ressources disponible, 
    inscrivez-vous et connectez-vous en cliquant <a href="/inscription">ici</a></p>