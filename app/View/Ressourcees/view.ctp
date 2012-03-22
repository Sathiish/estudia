<?php echo $this->Html->css('ressource', null, array('inline'=>false)); ?>

<div><span><img src="/img/titre/titre_ressources.png"</span></div>

<div class="filAriane">
    <?php echo $this->Html->link('Ressource', array("action"=> 'index')); ?>  
    <?php foreach($parents as $parent): $parent = current($parent); ?>
           >> <?php echo $this->Html->link($parent['titre'], array("action"=> 'view', $parent['id'], $parent['slug'])); ?>  
    <?php endforeach; ?>           
</div>

<div class="quadrillage">
    <div class="partie">
        <div class="vignette">
            <div class="vignette <?php echo slug($PageActive); ?>"><?php echo $this->Html->link('', array('action'=> 'view'));?></div>
            <img class="bottom" src="/img/cours/bottom_matiere.png" />
        </div>
    </div>

    <div class="theme"><span class="uppercase"><?php echo $PageActive; ?></span> <span class="bold">par thèmes</span></div>

</div>
    <div class="clr"></div>
    
<ul class="cours">
    <?php foreach($ressources as $ressource): $ressource=current($ressource); ?>
     <li>           
        <?php 
        ($ressource['type'] == "cours")? $targetLink = "sommaire": $targetLink = "view";
        echo $this->Html->link($ressource['titre'], array('action'=> $targetLink, $ressource['id'], $ressource['slug'])); 
         if($ressource['type'] != "cours"): ?>
         <img class="suite" title="créer un cours dans ce thème" src="/img/dashboard/plus2.png" width="16" height="16"/>
         <?php endif; ?>
    </li>
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