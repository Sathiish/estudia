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

if($_SESSION['Auth']['User']['id'] == $active['User']['id']):
    ?>

<div id="onglets_tutos" class="onglets_tutos">
  <ul>
    
      <li class="selected">
      <?php echo $this->Html->link('Tutoriel hors ligne',array("controller" => "ressources", "action" => "partie", $active['Ressource']['id'], $active['Ressource']['slug'])); ?></li>
    
      <li>
      <?php echo $this->Html->link('Edition',array("controller" => "ressources", "action" => "edit", $active['Ressource']['id'], $active['Ressource']['slug'])); ?></li>
    
  </ul>
</div>

<?php endif; ?>

<div id="" class="">

<?php
    
echo $active['Ressource']['titre'];
echo $active['Ressource']['contenu']; 
//debug($allChildren);
    foreach($allChildren as $child): $child = current($child); 
            if(($child['etat'] == "1") || ($child['etat'] == "0" && $child['user_id'] == $_SESSION['Auth']['User']['id'])){
                if($child['type'] == "sous-partie"){
                    echo '<div class="sous-partie"><span class="sous-partie titre">'.$child['titre'].'<span>';
                    echo $child['contenu'].'</div>';
                }
            }
    endforeach; ?>

<?php 
/*
 * Permet de naviguer entre les parties et les sous-parties d'un même parent
 * Si la partie suivante ou précédente n'est pas trouvée, alors on affiche le lien vers la catégorie parente.
 */
if($page['Parente']['Ressource']['type'] == "cours"){
    $targetLink = "sommaire";
}else{
    $targetLink = "partie";  
}

if(!empty($page['Precedente']['Ressource'])){ 
        echo $this->Html->link('<< '.$page['Precedente']['Ressource']['titre'], 
            array(
                "controller" =>"ressources", 
                "action" => "partie", 
                $page['Precedente']['Ressource']['id'], 
                $page['Precedente']['Ressource']['slug'])); 
    }else{
        echo $this->Html->link('Retourner sur "'.$page['Parente']['Ressource']['titre'].'"', 
            array(
                "controller" =>"ressources", 
                "action" => $targetLink, 
                $page['Parente']['Ressource']['id'], 
                $page['Parente']['Ressource']['slug'])); 
    }
?>

<div class="right">
<?php if(!empty($page['Suivante']['Ressource'])){ 
    echo $this->Html->link($page['Suivante']['Ressource']['titre']. '>>', 
            array(
                "controller" =>"ressources", 
                "action" => "partie", 
                $page['Suivante']['Ressource']['id'], 
                $page['Suivante']['Ressource']['slug'])); 
    
    }else{
        echo $this->Html->link('Retourner sur "'.$page['Parente']['Ressource']['titre'].'"', 
            array(
                "controller" =>"ressources", 
                "action" => $targetLink, 
                $page['Parente']['Ressource']['id'], 
                $page['Parente']['Ressource']['slug'])); 
    }?>
</div>
</div>