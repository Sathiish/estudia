<?php echo $this->Html->css('table', null, array('inline' => false));?>
<table class="manager">

    <th class="first">Matière</th>
    <th>Cours</th>
    <th class="last">Quiz</th>
<?php foreach ($matieres as $matiere): $matiere = current($matiere); ?>
    <tr>
    <td><?php echo $this->Html->link($matiere['name'], 
            array(
                "controller" => "courtags", 
                "action" => "view", 
                $matiere['id'], 
                $matiere['slug']
                )); ?>
    </td>
    <td class="center"><?php 
    if($matiere['count_published_cours'] == 0){
        echo '0';
    }else{
        echo $this->Html->link($matiere['count_published_cours'], array(
                    "controller" => "cours", 
                    "action" => "theme", 
                    $matiere['id'], 
                    $matiere['slug']
                    ));
    }?></td>
    <td class="center"><?php 
    if($matiere['count_published_quiz'] == 0){
        echo '0';
    }else{
        echo $this->Html->link($matiere['count_published_quiz'], array(
                "controller" => "quiz", 
                "action" => "theme", 
                $matiere['id'], 
                $matiere['slug']
                ));
    }?></td>
    
    </tr>
<?php endforeach; ?>

</table>
