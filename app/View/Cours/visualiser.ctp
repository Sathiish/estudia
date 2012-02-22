<div id="breadcrumbs">
        <?php echo $this->Html->link('Mes cours', array("controller" => "cours", "action" => "manager")); ?>
            >> <?php echo $p['Theme']['Matiere']['name'];?> 
            >> <?php echo $p['Theme']['name'];?>
            >> <?php echo $p['Cour']['name'];?>
</div>

<div id="onglets_tutos" class="onglets_tutos">
  <ul>
    
      <li class="selected">
      <?php echo $this->Html->link('Tutoriel hors ligne',array("controller" => "cours", "action" => "visualiser", $p['Cour']['id'], $p['Cour']['slug'])); ?></li>
    
      <li>
      <?php echo $this->Html->link('Edition',array("controller" => "cours", "action" => "edit", $p['Cour']['id'], $p['Cour']['slug'])); ?></li>
    
  </ul>
</div>

<div class="cours">
Auteur: <?php echo $this->Html->link($p['User']['username'], array("controller" => "users", "action" => "index", $p['User']['username'])); ?>
 :: Créé le <?php echo date("j M Y", strtotime($p['Cour']['created'])); ?>

<div class="contenu">
    <?php echo $p['Cour']['contenu']; ?>
</div>
 <div class="clr"></div>
 
 <?php if(!empty($p['Partie'])): ?>
 <div class="cours plan">
 <span class="titre">Ce cours contient les parties suivantes :</span>
 
    <ul class="sommaire">
        <?php foreach($p['Partie'] as $partie): 
        echo '<li>';
                
                    echo $this->Html->link($partie['sort_order'].'. '.$partie['name'], array("controller" => "parties", "action" => "visualiser", $partie['id'], $partie['slug'])); 
                    echo '<ul>';
                foreach($partie['SousPartie'] as $sousPartie):
                                        echo '<li>';
                    echo $this->Html->link('...'.$sousPartie['sort_order'].'. '.$sousPartie['name'], 
                            "/parties/visualiser/".$partie['id']."/".$partie['slug']."#".$sousPartie['slug']);                
                    echo '</li>';
                endforeach;
                                    echo '<ul>';

        echo '</li>';
            endforeach; ?>
    </ul>

 </div>   
 <?php endif; ?>
 
</div>



<?php $this->Html->script('jsMath/easy/load.js',array('inline'=>false)); ?>
<?php $this->Html->scriptStart(array('inline'=>false)); ?>
    jsMath.Process(document);
<?php $this->Html->scriptEnd(); ?>