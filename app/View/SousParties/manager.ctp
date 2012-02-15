<?php echo $this->Html->css('form', null, array('inline' => false));?>

<div id="breadcrumbs">
	<?php echo $this->Html->link("Mes cours", array("controller" => "cours", "action" => "manager"), array("title" => "Voir tous mes cours"));?>
            >> <?php echo $this->Html->link($path['Cour']['name'], array("controller" => "parties", "action" => "manager", $path['Cour']['id'], $path['Cour']['slug']), array("title" => "Voir ce cours"));?>
            <br />>> <?php echo $path['Partie']['name'];?> >> Ajouter/Supprimer/Modifier les sous-parties

</div>

<?php echo $this->Html->link('Ajouter une sous-partie', array('controller' => 'sousparties', 'action'=> 'add', $path['Partie']['id'], $path['Partie']['slug']), array('class' => 'button')); ?>

<?php if($sousParties != array()): ?>

<table id="parties">
   <thead>
     <tr>
        <th style="text-align: center">Cours</th>
        <th style="text-align: center; width:40px">Déplacer</th>
        <th style="text-align: center; width:210px">Actions</th>
     </tr>
     </thead>
     <tbody>
     <?php foreach($sousParties as $cours_info): $c = current($cours_info); ?>
        <tr>
             <td><?php echo $c['sort_order'].') '.$c['name'];?><br />

             <?php if($c['validation']){
                    if($c['public']){
                        echo '<span class="etat en_attente">En attente de dépublication</span>';
                    }
                    else{
                        echo '<span class="etat en_attente">En attente de publication</span>';
                    }
                }else{
                    if($c['public']){
                        echo '<span class="etat publie">Publié</span>';
                    }
                    else{
                        echo '<span class="etat non_publie">Non-publié</span>';
                    }                    
               
                }
                ?></td>
             <td style="text-align: center">
                <?php echo $this->Html->image('fleche_haut.png', array(
                    "url"=> array("action"=>"monter", $c['id'])
                ));?> / 
                <?php echo $this->Html->image('fleche_bas.png', array(
                    "url"=> array("action"=>"descendre", $c['id'])
                ));?>
             </td>
             <td style="text-align: left;">
             <?php if(!($c['public']) AND !($c['validation'])): ?>    
             <?php echo $this->Html->link('<span class="etat action">'.$this->Html->image('editer.png').' Modifier</span>', array("action"=>"edit", $c['id'], $c['slug']),array("escape" => false)); ?>
             <?php echo $this->Html->link('<span class="etat action">'.$this->Html->image('supprimer.png').' Supprimer</span>', 
                     array("action"=>"delete", $c['id']),
                     array("title" =>"Supprimer cette sous-partie", 'escape' => false),
                     "Etes-vous certain de vouloir définitivement supprimer cette sous-partie ?"
             );?><br />            
             <?php endif; ?>
             <?php 
             
             if(!$c['validation']){
                 if($c['public']){
                    echo $this->Html->link('<span class="etat action">Dépublier</span>', 
                         array("action"=>"askforunreleased", $c['id']),
                         array("title" =>"Demander la publication de ce quizz", 'escape' => false),
                         "Une fois dépublié, ce quiz n'apparaitra plus en ligne. Vous pourrez toutefois demander sa publication à nouveau. Souhaitez-vous toujours demander sa dépublication dès maintenant ?"
                    );
                 }else{
                    echo $this->Html->link('<span class="etat action">Publier</span>', 
                         array("action"=>"askforreleased", $c['id']),
                         array("title" =>"Demander la publication de ce quizz", 'escape' => false),
                         "Une fois publié, pour modifier ce quiz, vous devrez d'abord demander sa dépublication. Souhaitez-vous toujours demander la publication dès maintenant ?"
                    );  
                 }
                 
             
             }
             ?></td>
         </tr>
     <?php endforeach; ?>
     </tbody>
 </table>

<?php else: ?>
    <p>Vous n'avez ajouté aucunes sous-parties à ce cours pour le moment. Cliquez ci-dessus pour créer des sous-parties.</p>
<?php endif; ?>