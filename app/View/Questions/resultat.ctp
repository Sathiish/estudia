<div id="breadcrumbs">
    <?php echo $this->Html->link("Quiz par matières", array("controller" => "quiz", "action" => "index"), array("title" => "Voir tous les quiz"));?>
            >> <?php echo $this->Html->link(strip_tags($quiz_info['Ressource']['titre']), 
                    array("controller" => "quiz", "action" => "view", "id" => $quiz_info['Ressource']['id'], "slug" => $quiz_info['Ressource']['slug']), 
                    array("title" => "Voir tous les quiz de ce thème"));?><br />
            >> Mes résultats: <?php echo strip_tags($quiz_info['name']);?>
</div>

<table>
    
    <?php foreach ($reponses as $reponse):
        /*
         * On vérifie si la réponse est bonne, et on affiche le bon résultat
         */
        
        if($reponse['Answer'][0]['id'] == $reponse['UserAnswer'][0]['answer_id']){
            $resultat = "Réussi";
            $class = "publie";
        }else{
            $resultat = "Echec";
            $class = "non_publie";
        }
       
    ?>
    <tr>
        <td><?php echo strip_tags($reponse['Question']['question'],'<a><br />'); ?></td>
        <td style="text-align:center; width:80px"><?php echo $reponse['UserAnswer'][0]['time']; ?></td>
        <td style="text-align:center; width:80px"><?php echo $this->Html->link('<span class="etat '.$class.'">'.$resultat.'</span>', 
                array('controller'=>'questions', 'action'=> 'explication', $reponse['Question']['id']),
                array('escape' => false, 'title' => 'Voir la correction')
                ); ?></td>
    </tr>
    
    <?php endforeach; ?>
    
</table>