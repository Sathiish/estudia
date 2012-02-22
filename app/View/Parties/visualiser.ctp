<div id="breadcrumbs">
	<?php echo $p['Cour']['Theme']['Matiere']['name'];?> 
            >> <?php echo $p['Cour']['Theme']['name'];?>
            >> <?php echo $p['Cour']['name'];?>
</div>

<div id="onglets_tutos" class="onglets_tutos">
  <ul>
    
      <li class="selected">
      <?php echo $this->Html->link('Tutoriel hors ligne',array("controller" => "parties", "action" => "visualiser", $p['Partie']['id'], $p['Partie']['slug'])); ?></li>
    
      <li>
      <?php echo $this->Html->link('Edition',array("controller" => "parties", "action" => "edit", $p['Partie']['id'], $p['Partie']['slug'])); ?></li>
    
  </ul>
</div>

<div class="cours">

<?php echo $p['Partie']['name']; ?>
<?php echo $p['Partie']['contenu']; ?>


<?php foreach($p['SousPartie'] as $sousPartie): ?>
    <div id="<?php echo $sousPartie['slug'];?>" class="sous-partie">
        <h2><?php echo $sousPartie['name'];?><span style="text-decoration: none"> - <?php echo $this->Html->link('Modifier', array('controller' => 'sousparties', 'action' => 'edit', $sousPartie['id'], $sousPartie['slug'])); ?></span></h2>
        <?php echo $sousPartie['contenu'];?>
    </div>
<?php endforeach; ?>

</div>

<?php $this->Html->script('jsMath/easy/load.js',array('inline'=>false)); ?>
<?php $this->Html->scriptStart(array('inline'=>false)); ?>
    jsMath.Process(document);
<?php $this->Html->scriptEnd(); ?>