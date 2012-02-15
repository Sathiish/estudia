<?php echo $this->Html->css('form', null, array('inline' => false));?>

<h1>Créer/modifier une matière</h1>

<?php echo $this->Html->link('+ Ajouter un thème', array('action'=> 'create', $active['Ressource']['id'], $active['Ressource']['slug'])); ?>

<?php if(count($themes) == 0){ 
    
    echo "Cette matières n'a aucun thème pour l'instant";
}else{ ?>

<table id="parties">
    <thead>
         <tr>
            <th style="text-align: center">Titre du thème</th>
            <th style="text-align: center">Actions</th>
         </tr>
     </thead>
     <tbody>
       <?php $i=1; foreach($themes as $theme): $theme = current($theme); ?>
        <tr>
             <td><?php echo $i.') '.$theme['titre'];?></td>
             <td style="text-align: center">  
                <?php echo $this->Html->link($this->Html->image('editer.png')." Modifier", 
                        array("action"=>"edit", $theme['id'], $theme['slug']),
                        array("class"=>"modifier", "escape"=>false)); ?>
                <?php if($theme['type'] == "cours" OR $theme['type'] == "partie"): ?>
                <?php echo $this->Html->link($this->Html->image('editer.png')." Gérer les parties", 
                        array("action"=>"view", $theme['id'], $theme['slug']),
                        array("escape"=>false)); ?>
                <?php endif; ?>
                <?php echo $this->Html->link($this->Html->image('supprimer.png'), 
                     array("action"=>"delete", $theme['id']),
                     array("title" =>"Supprimer cette partie", 'escape' => false),
                     "Etes-vous certain de vouloir définitivement supprimer ce cours ?"
                );?>
             </td>
        </tr>
       <?php $i++; endforeach; ?>
     </tbody>
 </table>

<?php } ?>