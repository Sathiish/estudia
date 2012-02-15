<?php //debug($explication); ?>

<a href="<?php echo $back ?>">Revenir à la page précédente</a>

<p><?php echo $explication['Question']['question']; ?></p>

<?php if(isset($_SESSION['Auth']['User'])): ?>
Votre réponse était: <span class="bulle <?php echo ($explication['UserAnswer'][0]['Answer']['correct']) ? "success":"error"; ?>"><?php echo $explication['UserAnswer'][0]['Answer']['name'];?></span>
<?php endif; ?>

<hr />
La bonne réponse était: <?php echo $explication['Answer'][0]['name'];?>
<p>Explication:</p>

<?php echo $explication['Question']['explanation']; ?>