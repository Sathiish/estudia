<div class="cours">
Auteur: <?php echo $this->Html->link($c['User']['username'], array("controller" => "users", "action" => "index", $c['User']['username'])); ?>
 :: Créé le <?php echo date("j M Y", strtotime($c['Cour']['created'])); ?>

<div class="contenu">
    <?php echo $p['Cour']['contenu']; ?>
</div>
 <div class="clr"></div>

 <div class="cours plan">
 <span class="titre">Ce cours contient les parties suivantes :</span>
 
    <ul class="sommaire">
        <?php foreach($c['Partie'] as $partie): 
        echo '<li>';
                
                    echo $this->Html->link($partie['sort_order'].'. '.$partie['name'], array("controller" => "parties", "action" => "show", $partie['id'], $partie['slug'])); 
                    echo '<ul>';
                foreach($partie['SousPartie'] as $sousPartie):
                                        echo '<li>';
                    echo $this->Html->link('...'.$sousPartie['sort_order'].'. '.$sousPartie['name'], 
                            "/parties/show/".$partie['id']."/".$partie['slug']."#".$sousPartie['slug']);                
                    echo '</li>';
                endforeach;
                                    echo '<ul>';

        echo '</li>';
            endforeach; ?>
    </ul>

 </div>   
 
</div>