<?php echo $this->Html->css('form', null, array('inline' => false));?>

<h1>Créer/modifier une matière</h1>

<?php echo $this->Html->link('+ Ajouter une nouvelle matière', array('action'=> 'edit')); ?>

<table id="parties">
    <thead>
         <tr>
            <th style="text-align: center">Titre de la partie</th>
            <th style="text-align: center">Actions</th>
         </tr>
     </thead>
     <tbody>
       <?php $i=1; foreach($matieres as $matiere): $matiere = current($matiere); ?>
        <tr>
             <td><?php echo $i.') '.$matiere['titre'];?></td>
             <td style="text-align: center">  
                <?php echo $this->Html->link($this->Html->image('editer.png')." Modifier", 
                        array("action"=>"edit", $matiere['id'], $matiere['slug']),
                        array("class"=>"modifier", "escape"=>false)); ?>
                <?php echo $this->Html->link($this->Html->image('editer.png')." Gérer les thèmes", 
                        array("action"=>"view", $matiere['id'], $matiere['slug']),
                        array("escape"=>false)); ?>
                <?php echo $this->Html->link($this->Html->image('supprimer.png'), 
                     array("action"=>"delete", $matiere['id']),
                     array("title" =>"Supprimer cette partie", 'escape' => false),
                     "Etes-vous certain de vouloir définitivement supprimer ce cours ?"
                );?>
             </td>
        </tr>
       <?php $i++; endforeach; ?>
     </tbody>
 </table>