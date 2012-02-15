<?php echo $this->Html->css('form', null, array('inline' => false));?>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js" type="text/javascript"></script>


     <div class="titre"><?php echo $this->Html->image('titre/mescours.png', array('alt' => 'Titre cours','width'=>'100', 'height'=>'21')); ?></div>
     <div class="sous-titre"><img src="/img/fleche.png" /> Liste de mes cours</div>

     
<?php echo $this->Html->link('+ Créer un nouveau cours', array('action'=> 'edit'),array("style"=>"float:right; margin-right:20px;" )); ?>

<table id="parties">
   <thead>
     <tr>
        <th style="text-align: center">Titre du cours</th>
        <th style="text-align: center">Actions</th>
     </tr>
     </thead>
     <tbody>
     <?php $i=1; foreach($mescours as $cours): $cours = current($cours); ?>
        <tr>
             <td><?php echo $i.') '.$cours['titre'];?></td>
             <td style="text-align: center">
             <?php echo $this->Html->link($this->Html->image('editer.png'), array("action"=>"edit", $cours['id'], $cours['slug']),array("title" =>"Editer", "escape" => false)); ?>
             <?php echo $this->Html->link($this->Html->image('supprimer.png'), 
                     array("action"=>"delete", $cours['id']),
                     array("title" =>"Supprimer ce cours", 'escape' => false),
                     "Etes-vous certain de vouloir définitivement supprimer ce cours ?"
             );?>
             <?php echo $this->Html->link("Gérer les parties", array("action"=>"manager", $cours['id'], $cours['slug']),array("title" =>"Ajouter/supprimer/modifier les parties de ce cours", "escape"=>false)); ?>
             </td>

         </tr>
     <?php $i++; endforeach; ?>
     </tbody>
 </table>
     
     <?php debug($mescours); ?>