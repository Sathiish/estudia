<?php

foreach ($path as $link):
    switch($link['Ressource']['type']){
            case "theme":
                $linkTarget = 'view';
                break;
            case "matiere":
                $linkTarget = 'view';
                break;
            case "cours":
                $linkTarget = 'sommaire';
                break;
            default:
                $linkTarget = "partie";
        }
    echo ' >> '.$this->Html->link($link['Ressource']['titre'], array("controller" => "ressources", "action" => $linkTarget,$link['Ressource']['id'],$link['Ressource']['slug']));

endforeach;

if($_SESSION['Auth']['User']['id'] == $active['User']['id']){
    ?>

<div id="onglets_tutos" class="onglets_tutos">
  <ul>
    
      <li class="selected">
      <?php echo $this->Html->link('Tutoriel hors ligne',array("controller" => "ressources", "action" => "sommaire", $active['Ressource']['id'], $active['Ressource']['slug'])); ?></li>
    
      <li>
      <?php echo $this->Html->link('Edition',array("controller" => "ressources", "action" => "edit", $active['Ressource']['id'], $active['Ressource']['slug'])); ?></li>
    
  </ul>
</div>

<?php } ?>

Auteur: <?php echo $this->Html->link($active['User']['username'], array("controller" => "users", "action" => "index", $active['User']['username'])); ?>
 :: Créé le <?php echo date("j M Y", strtotime($active['Ressource']['created'])); ?>

<?php echo $this->Html->link("Voir le cours en entier", array('action'=> "show", $path['2']['Ressource']['id'], $path['2']['Ressource']['slug']), array("target" => "_blank")); ?>

<?php echo $active['Ressource']['contenu']; ?>

<hr />
    <ul>
        <?php $i=1; $j="a"; foreach($allChildren as $child): $child = current($child); ?>
            <li>     
                <?php  
        if(($child['etat'] == "1") || ($child['etat'] == "0" && $child['user_id'] == $_SESSION['Auth']['User']['id'])){
            if($child['type'] == "partie"){
                $j="a";
                echo $this->Html->link('Partie '.$i.': '.$child['titre'],array("controller" => "ressources", "action" => "partie", $child['id'], $child['slug'])); $i++;}
            else{
                 echo $this->Html->link('<span class="sous-partie titre">'.$j.'. '.$child['titre'].'<span>',array("controller" => "ressources", "action" => "partie", $child['id'], $child['slug']), array("escape" =>false));
                 $j++;
            }
        }?>
            </li>
        <?php endforeach; ?>
    </ul>

