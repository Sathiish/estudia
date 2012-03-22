<?php echo $this->Html->css('form', null, array('inline' => false));?>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js" type="text/javascript"></script>



<h1>Cours: <?php echo $active['Ressource']['titre']; ?></h1>

<?php if($_SESSION['Auth']['User']['id'] == $active['User']['id']){ ?>

<div id="onglets_tutos" class="onglets_tutos">
  <ul>
    
      <li>
      <?php echo $this->Html->link('Tutoriel hors ligne',array("controller" => "ressources", "action" => "sommaire", $active['Ressource']['id'], $active['Ressource']['slug'])); ?>
        </li>
    
      <li class="selected">
      <?php echo $this->Html->link('Edition',array("controller" => "ressources", "action" => "edit", $active['Ressource']['id'], $active['Ressource']['slug'])); ?></li>
    
  </ul>
</div>

<?php } ?>
    
Auteur: <?php echo $this->Html->link($active['User']['username'], array("controller" => "users", "action" => "index", $active['User']['username'])); ?>
 :: Créé le <?php echo date("j M Y", strtotime($active['Ressource']['created'])); ?>

<br /><br />Introduction: <br/>
 
<?php echo $active['Ressource']['contenu']; ?><br />

<?php echo $this->Html->link('+ Editer les informations de ce cours', array('action'=> 'edit', $active['Ressource']['id'], $active['Ressource']['slug'])); ?>
<?php echo $this->Html->link('+ Ajouter une nouvelle partie', array('action'=> 'add', $active['Ressource']['id'], $active['Ressource']['slug']),array("class"=>"modifier")); ?>

<br /><br />

<table id="parties">
    <thead>
         <tr>
            <th style="text-align: center">Titre de la partie</th>
            <th style="text-align: center">Monter/Descendre</th>
            <th style="text-align: center">Actions</th>
         </tr>
     </thead>
     <tbody>
       <?php $i=1; $j="a"; foreach($allChildren as $child): $child = current($child);   ?>
        <tr>
             <td><?php 
             
             if($child['type'] == "sous-partie"){
                    echo '<span class="sous-partie titre">'.$j.'. '.$child['titre'].'<span>'; $j++;
                }
                else{
                    echo $i.') '.$child['titre'];
                    $i++; $j="a";
                }
                ?></td>
             <td style="text-align: center">
                <?php echo $this->Html->image('fleche_haut.png', array(
                    "url"=> array("action"=>"monter", $child['id'],$child['slug'])
                ));?> / 
                <?php echo $this->Html->image('fleche_bas.png', array(
                    "url"=> array("action"=>"descendre", $child['id'], $child['slug'])
                ));?>
             </td>
             <td style="text-align: center">  
                <?php echo $this->Html->link($this->Html->image('editer.png'), 
                        array("action"=>"edit", $child['id'], $child['slug']),
                        array("title" => "Editer","escape"=>false)); ?>
                <?php echo $this->Html->link($this->Html->image('supprimer.png'), 
                     array("action"=>"delete", $child['id']),
                     array("title" =>"Supprimer cette partie", 'escape' => false),
                     "Etes-vous certain de vouloir définitivement supprimer ce cours ?"
                );?>
                <?php echo $this->Html->link("Demander la publication", 
                    array("action"=>"edit", $child['id'], $child['slug']),
                    array("escape"=>false)); ?>
             </td>
        </tr>
       <?php endforeach; ?>
     </tbody>
 </table>