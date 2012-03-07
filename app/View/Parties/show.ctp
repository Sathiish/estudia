<?php echo $this->Element('sharebar'); ?>

<?php echo $partie['Partie']['name']; ?>
<?php echo $partie['Partie']['contenu']; ?>

<?php foreach($partie['SousPartie'] as $sousPartie): ?>
    <div id="<?php echo $sousPartie['slug'];?>" class="sous-partie">
        <h2><?php echo $sousPartie['name'];?></h2>
        <?php echo $sousPartie['contenu'];?>
    </div>
<?php endforeach; ?>
