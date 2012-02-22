<?php echo $this->Html->css('form', null, array('inline' => false));?>
<?php $this->Html->script('jsMath/easy/load.js',array('inline'=>false)); ?>
<?php $this->Html->scriptStart(array('inline'=>false)); ?>
    jsMath.Process(document);
<?php $this->Html->scriptEnd(); ?>

<div id="breadcrumbs">
	<?php echo $this->Html->link("Gérer mes quiz", array("controller" => "quiz", "action" => "manager"), array("title" => "Voir tous mes quiz"));?>
            >> <?php echo $this->Html->link(strip_tags($info['Quiz']['name']), array("controller" => "questions", "action" => "manager", $info['Quiz']['id']), array("title" => "Quiz"));?><br />
            >> <?php echo strip_tags($info['Question']['question']); ?>
</div>

<?php echo $this->Html->link('Créer une nouvelle réponse', array('action'=> 'add', $info['Question']['id']), array('class' => 'button')); ?>

<h2><?php echo $info['Question']['question']; ?></h2>

<?php if($answers != array()): ?>
<table id="parties">
   <thead>
     <tr>
        <th style="text-align: center">Réponse</th>
        <th style="text-align: center; width:70px">Correcte</th>
        <th style="text-align: center; width:40px">Déplacer</th>
        <th style="text-align: center; width:30px">Actions</th>
     </tr>
     </thead>
     <tbody>
     <?php $i=1; foreach($answers as $answer): $answer = current($answer); ?>
        <tr>
            <td><?php echo $answer['sort_order'].') '.strip_tags($answer['name']);?></td>
             
             <td style="text-align: center"><?php ($answer['correct'] == 1)? $result= '<span class="etat publie">Correcte</span>': $result = '<span class="etat non_publie">Incorrecte</span>'; echo $result; ?></td>
             <td style="text-align: center">
                <?php echo $this->Html->image('fleche_haut.png', array(
                    "url"=> array("action"=>"monter", $answer['id'])
                ));?> / 
                <?php echo $this->Html->image('fleche_bas.png', array(
                    "url"=> array("action"=>"descendre", $answer['id'])
                ));?>
             </td>
             <td style="text-align: center">
             <?php echo $this->Html->link($this->Html->image('editer.png'), array("action"=>"edit", $answer['id']),array("escape" => false,'title' => 'Editer')); ?>
             
            <?php echo $this->Html->link($this->Html->image('supprimer.png'), 
                     array("action"=>"delete", $answer['id']),
                     array("title" =>"Supprimer cette", 'escape' => false),
                     "Etes-vous certain de vouloir définitivement supprimer ce cours ?"
             );?></td>

         </tr>
     <?php endforeach; ?>
     </tbody>
 </table>

<?php else: ?>

<p>Vous n'avez pas encore créé de réponse à cette question. Cliquez sur le bouton ci-dessus pour créer votre première réponse.<p>

<?php endif; ?>