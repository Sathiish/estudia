<?php echo $this->Html->css('ressource', null, array('inline'=>false)); ?>

<div class="main">
<div class="header">
    <div class="header_resize">

        <div class="grand-titre"><span><?php echo $active['Ressource']['titre']; ?></span><span class="fermer"><a style="color: #000; text-decoration: none;" onClick="window.close()" href="">X</a></span></div>
      
    </div>
</div>

</div>
<!-- END Header -->

<div class="content">		
    <div class="content_resize">        
        <div class="mainbar">
            <div class="intro">
Auteur: <?php echo $this->Html->link($active['User']['username'], array("controller" => "users", "action" => "index", $active['User']['username'])); ?>
 :: Créé le <?php echo date("j M Y", strtotime($active['Ressource']['created'])); ?>

<?php echo $active['Ressource']['contenu']; ?>

 <div class="cours plan">
 <span class="titre">Ce cours contient les parties suivantes :</span>
 
    <ul>
        <?php $i=1; foreach($allChildren as $child): $child = current($child); 
        echo '<li>';
                if($child['type'] == "partie"){
                    echo $this->Html->link($i.'. '.$child['titre'],"#".$child['slug']); $i++; $k="a"; 
                }else{
                    echo $this->Html->link('...'.$k.'. '.$child['titre'],"#".$child['slug']);$k++;
                }
        echo '</li>';
            endforeach; ?>
    </ul>

 </div>   
 
            </div>
<!--            FIN INTRO-->

 <ul>
    <?php $j=1; foreach($allChildren as $child): $child = current($child);
        if($child['type'] == "partie"): ?>
            <h3 id="<?php echo $child['slug'];?>"><?php echo 'Partie '.$j.': '.$child['titre'];?></h3>
            <?php echo $child['contenu']; $j++; $l = "a"; ?>
        <?php else: ?>
            <h4 id="<?php echo $child['slug'];?>"><?php echo 'Partie '.$l.': '.$child['titre'];?></h4>
            <?php echo $child['contenu']; $l++; ?>
            
        <?php endif; ?>
    <?php endforeach; ?>
</ul>

<?php
/*
 * Petite fonction qui permet de transformer les espaces et les accents en "-"
 * pour ne pas avoir de problème avec le CSS
 */
function slug($str) {
	$str = strtolower(trim($str));
	$str = preg_replace('/[^a-z0-9-]/', '-', $str);
	$str = preg_replace('/-+/', "-", $str);
	return $str;
}
?>