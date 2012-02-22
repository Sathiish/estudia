<?php //debug($explication); ?>

<a href="<?php echo $back ?>">Revenir à la page précédente</a>

<h2><?php echo $explication['Question']['question']; ?></h2>

<?php if(isset($_SESSION['Auth']['User'])): ?>
Votre réponse était: <span class="bulle <?php echo ($explication['UserAnswer'][0]['Answer']['correct']) ? "success":"error"; ?>"><?php echo $explication['UserAnswer'][0]['Answer']['name'];?></span>
<?php endif; ?>

<?php if(!$explication['UserAnswer'][0]['Answer']['correct']): ?>
<hr />
La bonne réponse est: <span class="bulle success"><?php echo $explication['Answer'][0]['name'];?></span>

<?php endif; ?>

<hr />

<h2>Explication:</h2>
<?php echo $explication['Question']['explanation']; ?>

<?php $this->Html->script('jsMath/easy/load.js',array('inline'=>false)); ?>
<?php $this->Html->scriptStart(array('inline'=>false)); ?>
    jsMath.Process(document);
<?php $this->Html->scriptEnd(); ?>